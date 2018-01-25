<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Salary\Logics\Payroll;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class GetPayrollUseCase
{

    public static function getData(Request $request)
    {
        return (new static)->handle($request);
    }

    abstract public function handle($request);
}