<?php

namespace App\Notification\Transformers;

use App\Notification\Models\NotificationRecipientGroup;
use App\Notification\Models\Notifications;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class NotificationRecipientTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(NotificationRecipientGroup $recipientGroup)
    {
        return [
            'id' => $recipientGroup->id,
            'employeeId' => $recipientGroup->employeeId,
            'employeeName'=>$this->getResultWithNullChecker1Connection($recipientGroup,'employee','givenName'),
            'groupTypeId' => $recipientGroup->groupTypeId,
            'groupTypeName'=>$this->getResultWithNullChecker1Connection($recipientGroup,'groupType','name')
        ];
    }


}
