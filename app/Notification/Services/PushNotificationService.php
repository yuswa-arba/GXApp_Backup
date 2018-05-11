<?php

namespace App\Notification\Services;

use App\Account\Events\UserNotified;
use App\Account\Models\User;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Notification\Models\Notifications;
use App\Log\Models\LogRequest;
use App\Traits\FirebaseUtils;
use App\Traits\GlobalConst;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{

    use GlobalUtils;
    use FirebaseUtils;

    public function __construct()
    {

    }


    public function singleNotify($data = array())
    {

        try {
            if ($data['sender'] && $data['userID'] && $data['title'] && $data['message'] && $data['viaType']) {

                if($data['viaType']==ConfigCodes::$NOTIFY_TYPE['NOTIFICATION']){

                    $notification = Notifications::create([
                        'userId' => $data['userID'],
                        'title' => $data['title'],
                        'message' => $data['message'],
                        'intentType' => $data['intentType'],
                        'viaType' => $data['viaType'],
                        'groupTypeId'=>array_key_exists('groupTypeId',$data)?$data['groupTypeId']:1,
                        'url'=>$data['url'],
                        'sendBy' => $this->getResultWithNullChecker1Connection($data['sender'], 'employee', 'givenName'),
                        'sendDate' => Carbon::now()->format('d/m/Y'),
                        'sendTime' => Carbon::now()->format('H:i')
                    ]);

                    if($notification){

                        //EVENT BROADCAST ECHO (FOR WEB)
                        $user = User::find($data['userID']);
                        $employee = $user->employee;
                        if($employee){
                            broadcast(new UserNotified($employee->id,$notification->id))->toOthers();
                        }

                        // FIREBASE PUSH NOTIFICATION
                        $this->sendSinglePush(
                            $data['userID'],
                            $data['title'],
                            $data['message'],
                            null,
                            $data['intentType']
                        );
                    }



                } else if($data['viaType']==ConfigCodes::$NOTIFY_TYPE['SMS']){
                    //TODO: send sms
                    //not supported yet
                }

            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

    }


}