<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 23/12/17
 * Time: 3:15 PM
 */

namespace App\Account\Logics\Users;

use App\Account\Transformers\LoginDetailTransfomer;
use App\Account\Transformers\UserDetailTransformer;
use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class UserAuthLogic extends AuthUseCase
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }


    public function handleLogin($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameter';
            return response()->json($response, 200);
        }

        //is valid

        return $this->issueToken($request, 'password');
    }

    /*@desc login succesful now return user's data*/
    public function handleLoginSuccessful()
    {
       $user = Auth::guard('api')->user();

       if($user){

           if($user->accessStatusId==1){

               $employee = $user->employee;

               if($employee && !$employee->hasResigned){ //success response

                   $response['isFailed'] = false;
                   $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                   $response['message'] = 'Success';
                   $response['user'] = fractal($user,new UserDetailTransformer())->toArray()['data'];

                   return response()->json($response,200);

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

    public function handleLogout($request)
    {
        $accessToken = Auth::guard('api')->user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        $response = array();
        $response['isFailed'] = false;
        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
        $response['message'] = 'Success';

        return response()->json($response, 200); //success response
    }

    public function handleRefresh($request)
    {
        $validator = Validator::make($request->all(), [
            'refresh_token' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameter';
            return response()->json($response, 200);
        }

        //is valid

        return $this->issueToken($request, 'refresh_token');
    }


}
