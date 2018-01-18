<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics;

use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Models\EmployeeSalary;
use App\Salary\Transformers\EmployeeBonusCutTransformer;
use App\Salary\Transformers\EmployeeSalaryTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UseBonusCutLogic extends UseBonusCutUseCase
{

    public function handle($request, $employeeId)
    {
        $response = array();
        $requestData = array();
        $requestData['employeeId'] = $request->employeeId;
        $requestData['salaryBonusCutTypeId'] = $request->bonusCutTypeId;

        $create = EmployeeBonusesCuts::create($requestData);
        if ($create) {
            $response['isFailed'] = false;
            $response['message'] = 'Bonus Cut has been created successfully';
            $response['bonusCut'] = fractal($create, new EmployeeBonusCutTransformer());
            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Error! Unable to create general bonus cut';
            return response()->json($response, 200);
        }

    }
}