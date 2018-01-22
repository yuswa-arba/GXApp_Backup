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

abstract class GenerateUseCase
{
    public static function generate(Request $request)
    {
         $response = array();

         $validator = Validator::make($request->all(),[
             'fromDate'=>'required',
             'toDate'=>'required',
             'branchOfficeId'=>'required'
         ]);

         if($validator->fails()){
             $response['isFailed'] = true;
             $response['message'] = 'Required parameter is missing';
             return response()->json($response,200);
         }

         //is valid

         return (new static)->handle($request);
    }

    abstract public function handle($request);

}