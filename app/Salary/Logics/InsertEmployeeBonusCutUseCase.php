<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Salary\Logics;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class InsertEmployeeBonusCutUseCase
{
    public static function save(Request $request, $employeeId)
    {

        $response = array();
        if ($employeeId != null && $employeeId != '') {

            if ($request->isUsingFormula) {
                $validator = Validator::make($request->all(), [
                    'bonusCutId' => 'required',
                    'formula' => 'required'
                ]);

                /* Emptying value*/
                $request->value = "";


            } else {
                $validator = Validator::make($request->all(), [
                    'bonusCutId' => 'required',
                    'value' => 'required'
                ]);

                /* Emptying formula*/
                $request->formula = "";
            }

            if ($validator->fails()) {
                $response['isFailed'] = true;
                $response['message'] = 'Required parameter is missing';
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