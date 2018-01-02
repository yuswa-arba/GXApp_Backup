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
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Attendance\Transformers\TimesheetListTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class GetTimesheetListLogic extends GetTimesheetDataUseCase
{
    use GlobalUtils;

    public function handleGetAllTimesheet($request)
    {
        $request->validate(['sortDate'=>'date_format:d/m/Y']);

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if($request->sortDate!=""){
            $sortDate = $request->sortDate;
        }

        //TODO : get data based on users permission


        $timesheet = AttendanceTimesheet::where('clockInDate',$sortDate)->orWhere('clockOutDate',$sortDate)->get();
        return fractal($timesheet,new TimesheetListTransformer())->respond(200);
    }

    public function handleTimesheetByDivsionAndShiftId($request)
    {
        // TODO: Implement handleTimesheetByDivsionAndShiftId() method.
    }

    public function handleTimesheetWithSpecificDivision($request)
    {
        // TODO: Implement handleTimesheetWithSpecificDivision() method.
    }

    public function handleTimesheetWithSpecificShift($request)
    {
        // TODO: Implement handleTimesheetWithSpecificShift() method.
    }
}