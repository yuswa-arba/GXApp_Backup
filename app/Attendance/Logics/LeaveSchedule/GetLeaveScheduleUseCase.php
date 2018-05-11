<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\LeaveSchedule;


use Illuminate\Http\Request;

abstract class GetLeaveScheduleUseCase
{
    public static function getData(Request $request)
    {
        $byAllDivision = true;

        if ($request->get('divisionId') != '') {
            $byAllDivision = false;
        }


        // by specific leave approval, by specific leave type
        if (!$byAllDivision ) {
            return (new static)->handlELSWithSpecificDivision($request);
        }


        return (new static)->handleAllELS($request);
    }

    abstract public function handleAllELS($request);
    abstract public function handlELSWithSpecificDivision($request);

}