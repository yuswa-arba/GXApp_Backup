<?php

namespace App\Http\Controllers\BackendV1\API\Auth;

use App\Account\Logics\Users\UserAuthLogic;
use App\Notification\Models\Notifications;
use App\Account\Models\User;
use App\Account\Models\UserPushToken;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Traits\FirebaseUtils;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Notification\Transformers\BriefPushNotificationTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class PushTokenController extends Controller
{

    use GlobalUtils;
    use ApiUtils;
    use FirebaseUtils;


    public function savePushToken(Request $request)
    {
        $response = array();


        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'type'=>'required'
            ]);

            if ($validator->fails()) {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                $response['message'] = 'Required paramater is missing';
                return response()->json($response, 200);
            }

            //is valid
            $insert = UserPushToken::updateOrCreate(
                ['userId'=>$user->id,'type'=>$request->type],
                ['token'=>$request->token]
            );

            if($insert){

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';


                return response()->json($response,200);
            } else{
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                $response['message'] = 'Unable to save data';

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
