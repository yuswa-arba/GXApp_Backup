<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\Timesheet;


use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class GetSingleTimesheetDataUseCase
{
    public static function getData(Request $request, $employeeId)
    {

        return (new static)->handleGetAllTimesheet($request,$employeeId);

    }

    abstract public function handleGetAllTimesheet($request,$employeeId);


}