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

use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class GetTimesheetListLogic extends GetTimesheetDataUseCase
{
    use GlobalUtils;


    public function handleGetList($request)
    {
        $validator = Validator::make($request->all(), ['sortDate' => 'date_format:d/m/Y']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Invalid date format';
            return response()->json($response, 200);
        }

        //is valid

        $sortDate = Carbon::now()->format('d/m/Y'); // Default Sort Date
        if ($request->sortDate != "") {
            $sortDate = $request->sortDate;
        }

        //TODO : get data based on users permission

        $query = '';

        /* Get timesheet */

        if ($request->attdApprovalId != '') { //by approval
            if ($query != '') { // add 'and' if its the first query for SQL Query syntax purposes
                $query .= ' and ';
            }

            $rawQuery = ' attendanceApproveId = "' . $request->attdApprovalId . '"';

            $query .= $rawQuery;
        }

        if ($request->shiftId != '') { // by shift
            if ($query != '') { // add 'and' if its the first query for SQL Query syntax purposes
                $query .= ' and ';
            }

            $rawQuery = ' shiftId = "' . $request->shiftId . '"';

            $query .= $rawQuery;
        }

        if ($request->divisionId != '') { // by division
            if ($query != '') { // add 'and' if its the first query for SQL Query syntax purposes
                $query .= ' and ';
            }

            $rawQuery = ' divisionId = "' . $request->divisionId . '"';

            $query .= $rawQuery;
        }


        if ($query != '') {

            if ($request->branchOfficeId != '' || $request->divisionId != '') {

                $innerQuery = '';

                if ($request->branchOfficeId != '') { //by branch
                    if ($innerQuery != '') { // add 'and' if its the first query for SQL Query syntax purposes
                        $innerQuery .= ' and ';
                    }

                    $rawInnerQuery = ' employment.branchOfficeId = "' . $request->branchOfficeId . '"';

                    $innerQuery .= $rawInnerQuery;
                }

                if ($request->divisionId != '') { //by division as well
                    if ($innerQuery != '') { // add 'and' if its the first query for SQL Query syntax purposes
                        $innerQuery .= ' and ';
                    }

                    $rawInnerQuery = ' employment.divisionId = "' . $request->divisionId . '"';

                    $innerQuery .= $rawInnerQuery;
                }


                $timesheet = AttendanceTimesheet::whereRaw($query)->where(function ($query) use ($sortDate) {
                    $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
                })->join('employment', function ($join) use ($innerQuery) {
                    $join->on('attendanceTimesheet.employeeId', '=', 'employment.employeeId')->whereRaw($innerQuery);
                })->orderBy('attendanceTimesheet.id', 'desc')->get();

            } else {
                $timesheet = AttendanceTimesheet::whereRaw($query)->where(function ($query) use ($sortDate) {
                    $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
                })->orderBy('id', 'desc')->get();
            }


        } else {

            if ($request->branchOfficeId != '' || $request->divisionId != '') {


                $innerQuery = '';


                if ($request->branchOfficeId != '') { //by branch
                    if ($innerQuery != '') { // add 'and' if its the first query for SQL Query syntax purposes
                        $innerQuery .= ' and ';
                    }

                    $rawInnerQuery = ' employment.branchOfficeId = "' . $request->branchOfficeId . '"';

                    $innerQuery .= $rawInnerQuery;
                }

                if ($request->divisionId != '') { //by division
                    if ($innerQuery != '') { // add 'and' if its the first query for SQL Query syntax purposes
                        $innerQuery .= ' and ';
                    }

                    $rawInnerQuery = ' employment.divisionId = "' . $request->divisionId . '"';

                    $innerQuery .= $rawInnerQuery;
                }


                $timesheet = AttendanceTimesheet::where(function ($query) use ($sortDate) {
                    $query->where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate);
                })->join('employment', function ($join) use ($innerQuery) {
                    $join->on('attendanceTimesheet.employeeId', '=', 'employment.employeeId')->whereRaw($innerQuery);
                })->orderBy('attendanceTimesheet.id', 'desc')->get();

            } else {
                $timesheet = AttendanceTimesheet::where('clockInDate', $sortDate)->orWhere('clockOutDate', $sortDate)->orderBy('id', 'desc')->get();

            }
        }

        return fractal($timesheet, new TimesheetListTransformer())->respond(200);
    }


}