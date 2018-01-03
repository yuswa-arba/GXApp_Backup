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
use App\Employee\Models\Employment;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class GetTimesheetListLogic extends GetTimesheetDataUseCase
{
    use GlobalUtils;

    public function handleGetAllTimesheet($request)
    {
        $request->validate(['sortDate' => 'date_format:d/m/Y']);

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if ($request->sortDate != "") {
            $sortDate = $request->sortDate;
        }

        //TODO : get data based on users permission

        /* Get timesheet */
        if ($request->attdApprovalId != '') {
            $timesheet = AttendanceTimesheet::where('attendanceApproveId', $request->attdApprovalId)->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->get();
        } else {
            $timesheet = AttendanceTimesheet::where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate)->get();

        }

        return fractal($timesheet, new TimesheetListTransformer())->respond(200);
    }

    public function handleTimesheetByDivsionAndShiftId($request)
    {
        $request->validate(['sortDate' => 'date_format:d/m/Y']);

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if ($request->sortDate != "") {
            $sortDate = $request->sortDate;
        }


        // Get employees with specific division
        $employments = Employment::where('divisionId', $request->divisionId)->get();
        $employeeIds = array();

        foreach ($employments as $employment) {
            //push employee id to array
            array_push($employeeIds, $employment->employeeId);
        }


        /* Get timesheet */
        if ($request->attdApprovalId != '') {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)->where('shiftId', $request->shiftId)->where('attendanceApproveId', $request->attdApprovalId)->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->get();
        } else {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)->where('shiftId', $request->shiftId)->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->get();
        }

        return fractal($timesheet, new TimesheetListTransformer())->respond(200);

    }

    public function handleTimesheetWithSpecificDivision($request)
    {
        //TODO : get data based on users permission

        $request->validate(['sortDate' => 'date_format:d/m/Y']);

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if ($request->sortDate != "") {
            $sortDate = $request->sortDate;
        }

        // Get employees with specific division
        $employments = Employment::where('divisionId', $request->divisionId)->get();
        $employeeIds = array();

        foreach ($employments as $employment) {
            //push employee id to array
            array_push($employeeIds, $employment->employeeId);
        }

        /* Get timesheet */
        if ($request->attdApprovalId != '') {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)
                ->where('attendanceApproveId', $request->attdApprovalId)
                ->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->get();
        } else {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->get();
        }


        return fractal($timesheet, new TimesheetListTransformer())->respond(200);
    }

    public function handleTimesheetWithSpecificShift($request)
    {
        //TODO : get data based on users permission

        $request->validate(['sortDate' => 'date_format:d/m/Y']);

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if ($request->sortDate != "") {
            $sortDate = $request->sortDate;
        }

        $timesheet = AttendanceTimesheet::where('shiftId', $request->shiftId)->where(function ($query) use ($sortDate) {
            $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
        })->get();
        return fractal($timesheet, new TimesheetListTransformer())->respond(200);
    }
}