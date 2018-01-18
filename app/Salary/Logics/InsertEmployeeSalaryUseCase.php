<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Salary\Logics;


use Illuminate\Http\Request;

abstract class InsertEmployeeSalaryUseCase
{
    public static function save(Request $request, $employeeId)
    {
        $response = array();

        if ($employeeId != null && $employeeId != '') {

            // validate basic salary cannot be empty
            if ($request->basicSalary == null || $request->basicSalary == '') {
                $response['isFailed'] = true;
                $response['message'] = 'Salary cannot be empty';

                return response()->json($response, 200);
            }

            //is valid run logic
            return (new static)->handle($request, $employeeId);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Parameter employee ID is missing';
            return response()->json($response, 200);
        }

    }

    abstract public function handle($request, $employeeId);


}