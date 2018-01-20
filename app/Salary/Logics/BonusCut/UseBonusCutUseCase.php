<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Salary\Logics\BonusCut;


use App\Salary\Models\EmployeeBonusesCuts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class UseBonusCutUseCase
{
    public static function use(Request $request, $employeeId)
    {
        $response = array();

        if ($employeeId != null && $employeeId != '') {

            $validator = Validator::make($request->all(), ['bonusCutTypeId' => 'required']);

            if ($validator->fails()) {
                $response['isFailed'] = true;
                $response['message'] = 'Required parameter is missing';
                return response()->json($response, 200);
            }


            $check = EmployeeBonusesCuts::where('salaryBonusCutTypeId', $request->bonusCutTypeId)->where('employeeId',$employeeId)->count();
            if ($check > 0) {
                $response['isFailed'] = true;
                $response['message'] = 'Error! Bonus cut has been used once';
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