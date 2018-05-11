<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics\Payroll;

use App\Salary\Models\GeneratePayroll;
use App\Salary\Transformers\GeneratePayrollTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class GetPayrollListLogic extends GetPayrollUseCase
{

    use GlobalUtils;


    public function handle($request)
    {
        $response = array();

        /* Year to get */
        $getYear = Carbon::now()->year;
        if ($request->year) {
            $getYear = $request->year;
        }

        $generatePayrolls = GeneratePayroll::whereYear('created_at', $getYear)->orderBy('id','desc')->get();

        if ($generatePayrolls) {

            $response['isFailed'] = false;
            $response['message'] = 'Successs';
            $response['generatedPayrollList'] = fractal($generatePayrolls, new GeneratePayrollTransformer())->toArray()['data'];

            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to get payroll data';
            return response()->json($response, 200);
        }

    }
}