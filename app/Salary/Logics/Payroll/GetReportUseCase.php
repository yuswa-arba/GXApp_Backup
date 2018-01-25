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

abstract class GetReportUseCase
{

    public static function getData($salaryReportLogId)
    {
        return (new static)->handle($salaryReportLogId);
    }

    abstract public function handle($request);
}