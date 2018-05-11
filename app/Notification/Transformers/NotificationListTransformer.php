<?php

namespace App\Notification\Transformers;

use App\Notification\Models\Notifications;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class NotificationListTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(Notifications $notifications)
    {
        return [
            'id' => $notifications->id,
            'title' => $notifications->title,
            'message' => $notifications->message,
            'url'=>$notifications->url,
            'sendBy' => $notifications->sendBy,
            'sendAt' => $notifications->sendDate . ' '. $notifications->sendTime,
            'hasSeen' => $notifications->hasSeen,
            'seenAt' => $notifications->seendDate.' '.$notifications->seenTime,
        ];
    }

}
