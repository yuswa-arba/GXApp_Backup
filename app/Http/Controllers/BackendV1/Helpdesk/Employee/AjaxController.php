<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Account\Models\User;
use App\Account\Transformers\LoginDetailTransfomer;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeDetailTransfomer;
use App\Employee\Transformers\EmploymentEditTransfomer;
use App\Employee\Transformers\EmploymentTransfomer;
use App\Http\Requests\Employee\EmploymentRequest;
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
                return response()->json(['message' => 'Error occured! Unable to find login data'], 500);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 500);
        }
    }

    public function employmentEdit($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $employment = Employment::where('employeeId',$employeeId)->first();

            if ($employment) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employment, new EmploymentEditTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employment data'], 500);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 500);
        }
    }

    public function saveEmploymentEdit(EmploymentRequest $request)
    {
        $response = array();
        $employment = Employment::where('employeeId',$request->employeeId)->first();

        if($employment){
            $employment->jobPositionId = $request->jobPositionId;
            $employment->divisionId = $request->divisionId;
            $employment->branchOfficeId = $request->branchOfficeId;
            $employment->recruitmentStatusId = $request->recruitmentStatusId;
            $employment->dateOfEntry = $request->dateOfEntry;
            $employment->dateOfStart = $request->dateOfStart;
            $employment->dateOfResignation = $request->dateOfResignation;
            $employment->save();

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Employment has been saved successfully';

            return response()->json($response,200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Error occured! Unable to find employment data';

            return response()->json($response,500);
        }


    }



}
