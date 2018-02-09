<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Notification\Logics\Send;


use App\Account\Models\PushNotifications;
use App\Employee\Models\MasterEmployee;
use App\Traits\FirebaseUtils;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class SendSingleNotificationLogic extends SendSingleNotificationUseCase
{

    use GlobalUtils;
    use FirebaseUtils;
    /*
     * @description send notification
     * */


    public function handleSendViaNotification($request)
    {

        $response = array();
        $employee = MasterEmployee::find($request->employeeId);

        if($employee && $employee->user->id){

            PushNotifications::create([
                'userId'=>$employee->user->id,
                'title'=>$request->title,
                'message'=>$request->message,
                'type'=>$request->sendToType,
                'intentType'=>$request->intentType,
                'viaType'=>$request->viaType,
                'sendBy'=>$this->getResultWithNullChecker1Connection(Auth::user(),'employee','givenName'),
                'sendDate'=>Carbon::now()->format('d/m/Y'),
                'sendTime'=>Carbon::now()->format('H:i')
            ]);

            $this->sendSinglePush(
                $employee->user->id,
                $request->title,
                $request->message,
                null,
                $request->intentType,
                $request->sendToType
            ); //send notification

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response,200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Employee not found';
            return response()->json($response,200);
        }

    }

    public function handleSendViaSMS($request)
    {
        // TODO: Implement handleSendViaSMS() method.
    }
}