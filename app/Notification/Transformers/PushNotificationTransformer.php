<?php

namespace App\Notification\Transformers;

use App\Account\Models\PushNotifications;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class PushNotificationTransformer extends TransformerAbstract
{

    public function transform(PushNotifications $pushNotifications)
    {
        return [
            'id' => $pushNotifications->id,
            'userId' => $pushNotifications->userId,
            'title' => $pushNotifications->title,
            'message' => $pushNotifications->message,
            'type' => $pushNotifications->type,
            'viaType' => $pushNotifications->viaType,
            'intentType' => $pushNotifications->intentType,
            'sendBy' => $pushNotifications->sendBy,
            'sendAt' => $pushNotifications->sendDate . ' '. $pushNotifications->sendTime,
            'hasSeen' => $pushNotifications->hasSeen,
            'seenAt' => $pushNotifications->seendDate.' '.$pushNotifications->seenTime
        ];
    }


}
