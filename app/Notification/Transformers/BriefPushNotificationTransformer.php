<?php

namespace App\Notification\Transformers;

use App\Account\Models\PushNotifications;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class BriefPushNotificationTransformer extends TransformerAbstract
{

    public function transform(PushNotifications $pushNotifications)
    {
        return [
            'id' => $pushNotifications->id,
            'title' => $pushNotifications->title,
            'message' => $pushNotifications->message,
            'hasSeen'=>$pushNotifications->hasSeen,
            'sendBy'=>$pushNotifications->sendBy,
            'sendAt'=>$pushNotifications->sendDate.' '.$pushNotifications->sendTime
        ];
    }


}
