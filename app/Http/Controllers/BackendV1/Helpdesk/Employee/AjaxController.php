<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeDetailTransfomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function employeeDetail($id)
    {
        if ($id != null && $id != '') {
            $employee = MasterEmployee::find($id);

            if ($employee) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employee, new EmployeeDetailTransfomer())->includeEmployment()
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 500);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 500);
        }
    }
}
