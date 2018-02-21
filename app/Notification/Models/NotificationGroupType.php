<?php

namespace App\Notification\Models;


use App\Account\Models\User;
use Illuminate\Database\Eloquent\Model;


class NotificationGroupType extends Model
{

    protected $table = 'notificationGroupType';


    protected $guarded = ['id'];


    public function recipient()
    {
        return $this->hasMany(NotificationRecipientGroup::class,'groupTypeId');
    }

}
