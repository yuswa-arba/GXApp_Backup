<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Employee\Logics\Recruitment;

use App\Http\Requests\Employee\EmploymentRequest;
use App\Http\Requests\Employee\MasterEmployeeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecruitmentController extends Controller
{

    public function createEmployee(MasterEmployeeRequest $request)
    {
        return Recruitment::createEmployeeLogic($request);
    }

    public function submitEmployment(EmploymentRequest $request)
    {
        return Recruitment::submitEmploymentLogic($request);
    }

}
