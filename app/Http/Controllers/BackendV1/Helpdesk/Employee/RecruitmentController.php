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
        Recruitment::submitEmploymentLogic($request);
    }

    // TODO : upload image logic is not working yet
    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'idCardPhoto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = time().'.'.$request->idCardPhoto->getClientOriginalExtension();
        $request->idCardPhoto->move(public_path('images'), $imageName);

        echo json_encode($imageName);

    }

}
