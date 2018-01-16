<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Employee\Logics\RecruitmentLogic;

use App\Http\Requests\Employee\EmploymentRequest;
use App\Http\Requests\Employee\MasterEmployeeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecruitmentController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware(['role:admin','permission:create employee']);
//    }

    public function createEmployee(MasterEmployeeRequest $request)
    {
        return RecruitmentLogic::createEmployee($request);
    }

    public function submitEmployment(EmploymentRequest $request)
    {
        return RecruitmentLogic::submitEmployment($request);
    }

}
