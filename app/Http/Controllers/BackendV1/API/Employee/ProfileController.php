<?php

namespace App\Http\Controllers\BackendV1\API\Employee;

use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    use GlobalUtils;
    use ApiUtils;

    public function changePassword(Request $request)
    {

        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            $validator = Validator::make($request->all(),[
                'oldPassword'=>'required',
                'newPassword'=>'required',
                'confirmNewPassword'=>'required'
            ]);


            if($validator->fails()){
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                $response['message'] = 'Required parameter is missing';

                return response()->json($response,200);
            }


            //is now valid

            if($request->newPassword==$request->confirmNewPassword){ //make sure confirmaiton password match

                if(Hash::check($request->oldPassword,$user->password)){

                    $hashPasswrod = Hash::make($request->newPassword);

                    $user->password = $hashPasswrod;
                    $user->save();

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Success';

                    //Logging
                    app()->make('LogService')->logging([
                        'causer'=>$this->getResultWithNullChecker1Connection($user,'employee','givenName'),
                        'via'=>'api call',
                        'subject'=>'Change Password',
                        'action'=>'write',
                        'level'=>3,
                        'description'=>$this->getResultWithNullChecker1Connection($user,'employee','givenName').' has changed their password',
                        'causerIPAddress'=> \Request::ip()
                    ]);


                    return response()->json($response,200);


                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$PROFILE_ERR_CODE['OLD_PASSWORD_INCORRECT'];
                    $response['message'] = 'Old password is incorrect';

                    return response()->json($response,200);
                }


            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$PROFILE_ERR_CODE['CONFIRMATION_DOESNT_MATCH'];
                $response['message'] = 'Password confirmation doesn\'t match';

                return response()->json($response,200);
            }


        } else {

            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);

        }
    }

}
