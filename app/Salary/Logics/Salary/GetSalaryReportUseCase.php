<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Salary\Logics\Salary;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class GetSalaryReportUseCase
{

    public static function getData($employeeId)
    {
        $response = array();

        if($employeeId==null||$employeeId==''){
            $response['isFailed'] = true;
            $response['message'] = 'Employee ID cannot be empty';
            return response()->json($response,200);
        }

        //is valid

        return (new static)->handle($employeeId);
    }

    abstract public function handle($employeeId);
}