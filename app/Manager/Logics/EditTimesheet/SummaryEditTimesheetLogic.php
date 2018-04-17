<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Manager\Logics\EditTimesheet;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Transformers\EmployeeSummaryTransformer;
use App\Attendance\Transformers\TimesheetSummaryTransformer;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class SummaryEditTimesheetLogic extends SummaryEditTimesheetUseCase
{
    use GlobalUtils;

    public function handle($editTimesheet)
    {

        $employees = MasterEmployee::whereHas('employment', function ($query) use ($editTimesheet) { //get only employee with selected branch office
            $query->where('branchOfficeId', $editTimesheet->branchOfficeId)->where('divisionId',$editTimesheet->divisionId);
        })->get();

        $dateRange = $this->generateDateRange($editTimesheet->startDate, $editTimesheet->endDate, 'd/m/Y');

        $response = array();
        $summary = array();
        foreach ($employees as $employee) {
            $response['employee'] = fractal($employee, new EmployeeSummaryTransformer());
            $i = 0;
            foreach ($dateRange as $date) {
                //$timesheet = AttendanceTimesheet::where('employeeId', $employee->id)->whereDate('created_at', $date)->get();
                $timesheet = AttendanceTimesheet::where('employeeId', $employee->id)->where(function ($query) use ($date) {
                    $query->where('clockInDate', '=', $date)->orWhere('clockOutDate', '=', $date);
                })->get();

                $datedmy = Carbon::createFromFormat('d/m/Y', $date)->format('d/m/Y');
                $response['timesheet'][$i]['date'] = $datedmy;
                $response['timesheet'][$i]['day'] = Carbon::createFromFormat('d/m/Y', $date)->format('D');
                $response['timesheet'][$i]['detail'] = fractal($timesheet, new TimesheetSummaryTransformer());
                $response['timesheet'][$i]['type'] = $this->checkDayType($employee->id, $datedmy);
                $response['timesheet'][$i]['editing'] = false;
                $response['timesheet'][$i]['allowToEdit'] =  Carbon::createFromFormat('d/m/Y',$editTimesheet->dueDate)->gt(Carbon::now()); //make sure has not passed due date;
                $i++;
            }
            $summary[] = $response;
        }

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['summary'] = $summary;

        return response()->json($response, 200);
    }

    private function checkDayType($employeeId, $datedmy)
    {
        $slotId = 1; // default

        // if slot Id found, update slotId variable
        if ($this->getEmployeeSlotId($employeeId)) {
            $slotId = $this->getEmployeeSlotId($employeeId);
        }

        // if its users paid leave
        if ($this->employeeLeaveSchedule($employeeId, $datedmy)) {
            return ['isHoliday' => true, 'notes' => Configs::$TIMESHEET_NOTES_INITIAL['PAID-LEAVE']];
        }

        // if its users day off
        if ($this->isDayOffForThisSlot($slotId, $datedmy)) {
            return ['isHoliday' => true, 'notes' => Configs::$TIMESHEET_NOTES_INITIAL['DAY-OFF']];
        }

        // if its users day off
        if ($this->isPublicHolidayForThisEmployee($employeeId, $slotId, $datedmy)) {
            return ['isHoliday' => true, 'notes' => Configs::$TIMESHEET_NOTES_INITIAL['PUBLIC-HOLIDAY']];
        }

        return ['isHoliday' => false, 'notes' => ''];

    }


    private function getEmployeeSlotId($employeeId)
    {
        $employeeSlotSchedule = EmployeeSlotSchedule::where('employeeId', $employeeId)->first();

        // if employee assigned to slot return slotId
        if ($employeeSlotSchedule) {
            return $employeeSlotSchedule->slotId;
        }

        // else return null
        return null;

    }

    private function isDayOffForThisSlot($slotId, $date)
    {

        return DayOffSchedule::where('slotId', $slotId)->where('date', $date)->count() > 0;

    }

    private function isPublicHolidayForThisEmployee($employeeId, $slotId, $date)
    {

        return PublicHolidaySchedule::where('fromSlotId', $slotId)
                ->where('applyDate', $date)
                ->where('employeeId', $employeeId)
                ->count() > 0;
    }


    private function employeeLeaveSchedule($employeeId, $date)
    {
        $isPaidLeaveExist = false;
        $paidLeaveSchedules = EmployeeLeaveSchedule::where('employeeId', $employeeId)
            ->where('month', Carbon::createFromFormat('d/m/Y',$date)->month)
            ->where('year', Carbon::createFromFormat('d/m/Y',$date)->year)
            ->where('leaveApprovalId', ConfigCodes::$LEAVE_APPROVAL['APPROVED'])
            ->get();

        foreach ($paidLeaveSchedules as $paidLeaveSchedule) {

            $parsedFromDate = Carbon::createFromFormat('d/m/Y', $paidLeaveSchedule->fromDate);
            $parsedToDate = Carbon::createFromFormat('d/m/Y', $paidLeaveSchedule->toDate);

            if ($paidLeaveSchedule->isStreakPaidLeave || $paidLeaveSchedule->totalDays>1) {
                $today = Carbon::now();
                if ($today->gte($parsedFromDate) && $today->lte($parsedToDate)) {
                    $isPaidLeaveExist = true;
                }
            } else {
                if($paidLeaveSchedule->fromDate==Carbon::now()->format('d/m/Y')){
                    $isPaidLeaveExist = true;
                }
            }

        }

        return $isPaidLeaveExist;
    }


}