<?php

namespace App\Http\Controllers\BackendV1\API\Inbox;

use App\Notification\Models\Notifications;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Notification\Transformers\BriefPushNotificationTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class PushNotificationController extends Controller
{
    use ApiUtils;

    public function getPushNotificationList()
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            //is valid
            $pushNotifications = Notifications::where('userId',$user->id)->orderBy('hasSeen','asc')->orderBy('created_at','desc')->paginate(30);

            if($pushNotifications){

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['pushNotificationResponse'] = fractal($pushNotifications,new BriefPushNotificationTransformer());

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

    public function seenPushNotification()
    {
        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            //is valid
            $updateHasSeen = Notifications::where('userId',$user->id)->where('hasSeen','0')->update([
                'hasSeen'=>1,
                'seenDate'=>Carbon::now()->format('d/m/Y'),
                'seenTime'=>Carbon::now()->format('H:i')
            ]);

            if($updateHasSeen){

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
