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
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\EmployeeSummaryTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Attendance\Transformers\TimesheetListTransformer;
use App\Attendance\Transformers\TimesheetSummaryTransformer;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeDetailTransfomer;
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
        $dateRange = $this->generateDateRangeFromFormatToFormat($request->fromDate, $request->toDate, 'd/m/Y', 'Y-m-d');

        $response = array();
        $summary = array();
        foreach ($employees as $employee) {
            $response['employee'] = fractal($employee, new EmployeeSummaryTransformer());
            $i = 0;
            foreach ($dateRange as $date) {
                $timesheet = AttendanceTimesheet::where('employeeId', $employee->id)->whereDate('created_at', $date)->get();

                $datedmy = Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
                $response['timesheet'][$i]['date'] = $datedmy;
                $response['timesheet'][$i]['day'] = Carbon::createFromFormat('Y-m-d', $date)->format('D');
                $response['timesheet'][$i]['detail'] = fractal($timesheet, new TimesheetSummaryTransformer());
                $i++;
            }

            $summary[] = $response;
        }

        return $summary;
    }

    public function handleSummaryWithSpecificEmployee($request)
    {
        // TODO: Implement handleSummaryWithSpecificEmployee() method.
    }

    public function handleSummaryWithSpecificDivision($request)
    {
        // TODO: Implement handleSummaryWithSpecificDivision() method.
    }
}