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

abstract class GetTimesheetDataUseCase
{
    public static function getData(Request $request)
    {

        return (new static)->handleGetList($request);

    }

    abstract public function handleGetList($request);


}