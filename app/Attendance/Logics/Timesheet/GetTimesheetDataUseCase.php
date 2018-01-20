<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\Timesheet;


use Illuminate\Http\Request;

abstract class GetTimesheetDataUseCase
{
    public static function getData(Request $request)
    {

        $byAllDivision = true;
        $byAllShiftId = true;

        if ($request->get('divisionId') != '') {
            $byAllDivision = false;
        }

        if ($request->get('shiftId') != '') {
            $byAllShiftId = false;
        }

        // by specific division, by specific shift
        if (!$byAllDivision && !$byAllShiftId) {
            return (new static)->handleTimesheetByDivsionAndShiftId($request);
        }

        // by division,  by all shift
        if (!$byAllDivision && $byAllShiftId) {
            return (new static)->handleTimesheetWithSpecificDivision($request);
        }

        // by specific shift, by all division
        if (!$byAllShiftId && $byAllDivision) {
            return (new static)->handleTimesheetWithSpecificShift($request);
        }



        return (new static)->handleGetAllTimesheet($request);

    }

    abstract public function handleGetAllTimesheet($request);
    abstract public function handleTimesheetByDivsionAndShiftId($request);
    abstract public function handleTimesheetWithSpecificDivision($request);
    abstract public function handleTimesheetWithSpecificShift($request);


}