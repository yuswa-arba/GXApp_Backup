<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics;

use App\Salary\Models\EmployeeSalary;
use App\Salary\Transformers\EmployeeSalaryTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class InsertEmployeeSalaryLogic extends InsertEmployeeSalaryUseCase
{


    public function handle($request, $employeeId)
    {
        $response = array();

        $insert = EmployeeSalary::updateOrCreate(
            ['employeeId' => $employeeId], // if this employee is found update it instead create a new one
            [
                'basicSalary' => $request->basicSalary,
                'insertedDate' => Carbon::now()->format('d/m/Y'),
                'insertedBy' => !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : ''
            ]
        );

        /* Insert it to database */
        if ($insert) {

            $response = array();
            $response['isFailed'] = false;
            $response['message'] = 'Salary has been inserted successfully';
            $response['salary'] = fractal($insert,new EmployeeSalaryTransformer());

            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to insert employee salary';
            return response()->json($response, 200);
        }
    }
}