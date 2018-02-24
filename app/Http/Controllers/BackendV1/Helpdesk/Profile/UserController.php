<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Profile;


use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    use GlobalUtils;

    public function detail(Request $request)
    {

        $response = array();

        $user = Auth::user();
        $employee = $user->employee;

        if ($employee) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['employee'] = fractal($employee, new EmployeeBriefDetailTransfomer());

            return response()->json($response, 200);


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find employee data';

            return response()->json($response, 200);
        }

    }

    public function changePassword(Request $request)
    {

        $response = array();

        $user = Auth::user();

        $validator = Validator::make($request->all(),
            [
                'oldPwd' => 'required',
                'newPwd' => 'required',
                'confirmNewPwd' => 'required'
            ]
        );

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }


        if ($request->newPwd != $request->confirmNewPwd) {
            $response['isFailed'] = true;
            $response['message'] = 'Confirm new password does not match';
            return response()->json($response, 200);
        }

        //is valid

        if (Hash::check($request->oldPwd, $user->password)) {

            $hashedNewPassword = Hash::make($request->newPwd);
            $user->password = $hashedNewPassword;

            if ($user->save()) { /* Success response */

                //Logging
                app()->make('LogService')->logging([
                    'causer' => $this->getResultWithNullChecker1Connection($user, 'employee', 'givenName'),
                    'via' => 'web client',
                    'subject' => 'Change Password',
                    'action' => 'write',
                    'level' => 3,
                    'description' => $this->getResultWithNullChecker1Connection($user, 'employee', 'givenName') . ' has changed their password',
                    'causerIPAddress' => \Request::ip()
                ]);

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                return response()->json($response, 200);

            } else { /* Error repsonse */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save new password';
                return response()->json($response, 200);
            }

        } else { /* Error repsonse */
            $response['isFailed'] = true;
            $response['message'] = 'Old password does not match';
            return response()->json($response, 200);
        }


    }

    public function getEmployeeId()
    {
        $user = Auth::user();
        $employee = $user->employee;

        $response = array();

        if ($employee) {

            if ($employee->hasResigned == 1) {
                $response['isFailed'] = true;
                $response['message'] = 'Employee has resigned';
                return response()->json($response, 200);
            }

            //is valid
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['employeeId'] = $employee->id;

            return response()->json($response, 200);


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to get employee data';
            return response()->json($response, 200);
        }
    }
}