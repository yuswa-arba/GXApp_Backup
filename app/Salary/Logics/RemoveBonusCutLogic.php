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


class RemoveBonusCutLogic extends RemoveBonusCutUseCase
{

    public function handle($request, $employeeId)
    {
        $response = array();

        $delete = EmployeeBonusesCuts::find($request->bonusCutId)->delete();

        if ($delete) {
            $response['isFailed'] = false;
            $response['message'] = 'Bonus Cut has been deleted successfully';
            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Error! Unable to delete bonus cut';
            return response()->json($response, 200);
        }

    }
}