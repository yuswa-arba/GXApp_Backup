<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Salary\Transformers\EmployeeBonusCutTransformer;
use App\Salary\Transformers\EmployeeSalaryTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
    }


    public function detail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {
            $employee = MasterEmployee::find($employeeId);

            if ($employee) {
                return response()->json([
                    'message' => 'Successful',
                    'employee' => fractal($employee, new EmployeeBriefDetailTransfomer()),
                    'salary'=>fractal($employee->salary,new EmployeeSalaryTransformer()),
                    'bonusCut'=>fractal($employee->bonusCut,new EmployeeBonusCutTransformer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

}
