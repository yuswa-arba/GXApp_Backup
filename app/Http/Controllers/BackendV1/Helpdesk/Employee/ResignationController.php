<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Employee\Logics\EmployeeSearchLogic;
use App\Employee\Logics\RecruitmentLogic;

use App\Employee\Logics\Resignation;
use App\Employee\Logics\ResignationLogic;
use App\Http\Requests\Employee\EmploymentRequest;
use App\Http\Requests\Employee\MasterEmployeeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ResignationController extends Controller
{

    public function resign(Request $request)
    {

        $rules = array();

        if ($request->professionalism != '' && $request->professionalism != null) {
            if ($request->professionalism == 'professional') {
                $rules = [
                    'employeeId' => 'required',
                    'submissionDate' => 'required|date_format:d/m/Y',
                    'effectiveDate' => 'required|date_format:d/m/Y',
                    'resignationLetter' => 'required',
                    'reason' => 'required',
                    'professionalism' => 'required'
                ];
            } elseif ($request->professionalism == 'unprofessional') {
                $rules = [
                    'employeeId' => 'required',
                    'effectiveDate' => 'required|date_format:d/m/Y',
                    'notes' => 'required',
                    'professionalism' => 'required'
                ];
            }

            $validator = Validator::make($request->all(), $rules);


            if ($validator->fails()) {
                $response['isFailed'] = true;
                $response['message'] = 'Missing required parameters';
                return response()->json($response, 200);
            }

            //is valid, run logic

            return ResignationLogic::resign($request);


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Professionalism is undefined';
            return response()->json($response, 200);
        }


    }

}
