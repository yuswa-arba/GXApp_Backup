<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\Timesheet;


use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use Illuminate\Http\Request;

abstract class SummarizeTimesheetUseCase
{
    public static function getData(Request $request, $sumType)
    {

        if($sumType==ConfigCodes::$SUM_TYPE['ALL']){
            return (new static)->handleAllSummary($request);
        }

        if($sumType==ConfigCodes::$SUM_TYPE['EMPLOYEE']){
            return (new static)->handleSummaryWithSpecificEmployee($request);
        }

        if($sumType==ConfigCodes::$SUM_TYPE['DIVISION']){
            return (new static)->handleSummaryWithSpecificDivision($request);
        }

        return (new static)->handleAllSummary($request);

    }

    abstract public function handleAllSummary($request);
    abstract public function handleSummaryWithSpecificEmployee($request);
    abstract public function handleSummaryWithSpecificDivision($request);

}