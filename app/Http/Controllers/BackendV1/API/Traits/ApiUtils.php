<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */
namespace App\Http\Controllers\BackendV1\API\Traits;


use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


trait ApiUtils
{

    public function checkUserEmployee()
    {
        $user = Auth::guard('api')->user();

        if ($user) {

            if ($user->accessStatusId == 1) {

                $employee = $user->employee;

                if ($employee && !$employee->hasResigned) { //success response

                    //is valid
                    return true;

                } else { // user employee data not found or has resigned return error response
                    return false;
                }
            } else { // user access is not granted return error response
                return false;
            }
        } else {//user not found return error response
            return false;
        }
    }

    public function checkUserEmployeeWithResponse()
    {
        $user = Auth::guard('api')->user();

        if ($user) {

            if ($user->accessStatusId == 1) {

                $employee = $user->employee;

                if ($employee && !$employee->hasResigned) { //success response

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Success';

                    return response()->json($response, 200);

                } else { // user employee data not found or has resigned return error response
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_EMPLOYEE_DATA_NOT_FOUND'];
                    $response['message'] = 'User\'s employee data not found or has resigned';

                    return response()->json($response, 200);
                }
            } else { // user access is not granted return error response
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
                $response['message'] = 'User\'s access not granted';

                return response()->json($response, 200);
            }

        } else {//user not found return error response
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_NOT_FOUND'];
            $response['message'] = 'Error! User not found';

            return response()->json($response, 200);
        }
    }

}