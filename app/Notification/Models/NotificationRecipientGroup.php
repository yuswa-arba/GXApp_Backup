<?php

namespace App\Notification\Models;


use App\Account\Models\User;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;


class NotificationRecipientGroup extends Model
{

    protected $table = 'notificationRecipientGroup';


    protected $guarded = ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function groupType()
    {
        return $this->belongsTo(NotificationGroupType::class,'groupTypeId');
    }

}
