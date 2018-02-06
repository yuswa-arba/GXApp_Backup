<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Timesheet;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Transformers\TimesheetListTransformer;
use App\Employee\Models\Employment;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


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
            })->orderBy('id','desc')->get();
        } else {
            $timesheet = AttendanceTimesheet::where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate)->orderBy('id','desc')->get();
        }

        //Logging
        app()->make('LogService')->logging([
            'causer'=>$this->getResultWithNullChecker1Connection(Auth::user(),'employee','givenName'),
            'via'=>'web client',
            'subject'=>'Read Timesheet',
            'action'=>'read',
            'level'=>3,
            'description'=>'Get all timesheet data, sort date: ' . $sortDate,
            'causerIPAddress'=> \Request::ip()
        ]);

        return fractal($timesheet, new TimesheetListTransformer())->respond(200);
    }

    public function handleTimesheetByDivsionAndShiftId($request)
    {
        $request->validate(['sortDate' => 'date_format:d/m/Y']);

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if ($request->sortDate != "") {
            $sortDate = $request->sortDate;
        }

        $employeeIds =Employment::where('divisionId', $request->divisionId)->get()->pluck('employeeId');

        /* Get timesheet */
        if ($request->attdApprovalId != '') {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)->where('shiftId', $request->shiftId)->where('attendanceApproveId', $request->attdApprovalId)->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->orderBy('id','desc')->get();
        } else {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)->where('shiftId', $request->shiftId)->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->orderBy('id','desc')->get();
        }

        //Logging
        app()->make('LogService')->logging([
            'causer'=>$this->getResultWithNullChecker1Connection(Auth::user(),'employee','givenName'),
            'via'=>'web client',
            'subject'=>'Read Timesheet',
            'action'=>'read',
            'level'=>3,
            'description'=>'Get timesheet data by division: '. $request->divisionId .' & shift: '.$request->shiftId.', sort date: ' . $sortDate,
            'causerIPAddress'=> \Request::ip()
        ]);

        return fractal($timesheet, new TimesheetListTransformer())->respond(200);

    }

    public function handleTimesheetWithSpecificDivision($request)
    {
        //TODO : get data based on users is division manager of what

        $request->validate(['sortDate' => 'date_format:d/m/Y']);

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if ($request->sortDate != "") {
            $sortDate = $request->sortDate;
        }

        $employeeIds =Employment::where('divisionId', $request->divisionId)->get()->pluck('employeeId');

        /* Get timesheet */
        if ($request->attdApprovalId != '') {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)
                ->where('attendanceApproveId', $request->attdApprovalId)
                ->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->orderBy('id','desc')->get();
        } else {
            $timesheet = AttendanceTimesheet::whereIn('employeeId', $employeeIds)->where(function ($query) use ($sortDate) {
                $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
            })->orderBy('id','desc')->get();
        }

        //Logging
        app()->make('LogService')->logging([
            'causer'=>$this->getResultWithNullChecker1Connection(Auth::user(),'employee','givenName'),
            'via'=>'web client',
            'subject'=>'Read Timesheet',
            'action'=>'read',
            'level'=>3,
            'description'=>'Get timesheet data by division: '. $request->divisionId .', sort date: ' . $sortDate,
            'causerIPAddress'=> \Request::ip()
        ]);

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
        })->orderBy('id','desc')->get();


        //Logging
        app()->make('LogService')->logging([
            'causer'=>$this->getResultWithNullChecker1Connection(Auth::user(),'employee','givenName'),
            'via'=>'web client',
            'subject'=>'Read Timesheet',
            'action'=>'read',
            'level'=>3,
            'description'=>'Get timesheet data by shift: '. $request->shiftId .', sort date: ' . $sortDate,
            'causerIPAddress'=> \Request::ip()
        ]);

        return fractal($timesheet, new TimesheetListTransformer())->respond(200);
    }
}