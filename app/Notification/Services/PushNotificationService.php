<?php

namespace App\Notification\Services;

use App\Account\Models\PushNotifications;
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
            if ($data['sender'] && $data['userID'] && $data['title'] && $data['message'] && $data['sendToType']
                && $data['intentType'] && $data['viaType']
            ) {
                PushNotifications::create([
                    'userId' => $data['userID'],
                    'title' => $data['title'],
                    'message' => $data['message'],
                    'type' => $data['sendToType'],
                    'intentType' => $data['intentType'],
                    'viaType' => $data['viaType'],
                    'sendBy' => $this->getResultWithNullChecker1Connection($data['sender'], 'employee', 'givenName'),
                    'sendDate' => Carbon::now()->format('d/m/Y'),
                    'sendTime' => Carbon::now()->format('H:i')
                ]);


                $this->sendSinglePush(
                    $data['userID'],
                    $data['title'],
                    $data['message'],
                    null,
                    $data['intentType'],
                    $data['sendToType']
                ); //send notification
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

    }


}