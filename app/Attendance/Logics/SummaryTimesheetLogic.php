<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\EmployeeSummaryTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Attendance\Transformers\TimesheetListTransformer;
use App\Attendance\Transformers\TimesheetSummaryTransformer;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeDetailTransfomer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class SummaryTimesheetLogic extends SummarizeTimesheetUseCase
{
    use GlobalUtils;

    public function handleAllSummary($request)
    {
        $employees = MasterEmployee::all();

        $fromDate = Carbon::createFromFormat('d/m/Y H:i', $request->fromDate . '00:00')->toDateTimeString();
        $toDate = Carbon::createFromFormat('d/m/Y H:i', $request->toDate . '23:59')->toDateTimeString();
        // $dateRange = $this->generateDateRangeFromFormatToFormat($request->fromDate, $request->toDate, 'd/m/Y', 'Y-m-d');
        $dateRange = $this->generateDateRange($request->fromDate, $request->toDate, 'd/m/Y');

        $response = array();
        $summary = array();
        foreach ($employees as $employee) {
            $response['employee'] = fractal($employee, new EmployeeSummaryTransformer());
            $i = 0;
            foreach ($dateRange as $date) {
                //$timesheet = AttendanceTimesheet::where('employeeId', $employee->id)->whereDate('created_at', $date)->get();
                $timesheet = AttendanceTimesheet::where('employeeId', $employee->id)->where(function ($query) use ($date) {
                    $query->where('clockInDate','=',$date)->orWhere('clockOutDate','=',$date);
                })->get();

                $datedmy = Carbon::createFromFormat('d/m/Y', $date)->format('d/m/Y');
                $response['timesheet'][$i]['date'] = $datedmy;
                $response['timesheet'][$i]['day'] = Carbon::createFromFormat('d/m/Y', $date)->format('D');
                $response['timesheet'][$i]['detail'] = fractal($timesheet, new TimesheetSummaryTransformer());
                $response['timesheet'][$i]['type'] = $this->checkDayType($employee->id,$datedmy);
                $response['timesheet'][$i]['editing'] = false;

                $i++;
            }

            $summary[] = $response;
        }

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'success';
        $response['summary'] = $summary;
        return response()->json($response,200);
    }

    public function handleSummaryWithSpecificEmployee($request)
    {
        // TODO: Implement handleSummaryWithSpecificEmployee() method.
    }

    public function handleSummaryWithSpecificDivision($request)
    {
        // TODO: Implement handleSummaryWithSpecificDivision() method.
    }



    private function checkDayType($employeeId,$datedmy)
    {
        $slotId = 1; // default

        // if slot Id found, update slotId variable
        if($this->getEmployeeSlotId($employeeId)){
            $slotId = $this->getEmployeeSlotId($employeeId);
        }

        // if its users paid leave
        if($this->employeeLeaveSchedule($employeeId,$datedmy)){
            return ['isHoliday'=>true,'notes'=>Configs::$TIMESHEET_NOTES_INITIAL['PAID-LEAVE']];
        }

        // if its users day off
        if($this->isDayOffForThisSlot($slotId,$datedmy)){
            return ['isHoliday'=>true,'notes'=>Configs::$TIMESHEET_NOTES_INITIAL['DAY-OFF']];
        }

        return ['isHoliday'=>false,'notes'=>''];

    }


    private function getEmployeeSlotId($employeeId)
    {
        $employeeSlotSchedule = EmployeeSlotSchedule::where('employeeId',$employeeId)->first();

        // if employee assigned to slot return slotId
        if($employeeSlotSchedule){
            return $employeeSlotSchedule->slotId;
        }

        // else return null
        return null;

    }

    private function isDayOffForThisSlot($slotId, $date)
    {

        $checkDayOffSchedule =  DayOffSchedule::where('slotId',$slotId)->where('date',$date)->count();

        // if day off schedule found return TRUE
        if($checkDayOffSchedule>0){
            return true;
        }

        // else return FALSE
        return false;

    }

    private function employeeLeaveSchedule($employeeIds, $date)
    {
        //TODO: CHECK IF THIS SPECIFIC DATE IS EMPLOYEE LEAVE SCHEDULE
        return false;
    }


}