<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Account\Models\User;
use App\Account\Transformers\LoginDetailTransfomer;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeDetailTransfomer;
use App\Employee\Transformers\EmploymentTransfomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function masterEmploymentDetail($id)
    {
        if ($id != null && $id != '') {
            $employee = MasterEmployee::find($id);

            if ($employee) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employee, new EmployeeDetailTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 500);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 500);
        }
    }

    public function employmentDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $employment = Employment::where('employeeId',$employeeId)->first();

            if ($employment) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employment, new EmploymentTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 500);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 500);
        }
    }

    public function loginDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $user = User::where('employeeId',$employeeId)->first();

            if ($user) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($user, new LoginDetailTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 500);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 500);
        }
    }

}
