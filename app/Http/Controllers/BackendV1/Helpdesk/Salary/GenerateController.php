<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Salary\Logics\Salary\GenerateSalaryLogic;
use App\Traits\GlobalUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenerateController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
//        $this->middleware(['permission:access salary']);
    }

    public function generate(Request $request)
    {
        return GenerateSalaryLogic::generate($request);
    }

}
