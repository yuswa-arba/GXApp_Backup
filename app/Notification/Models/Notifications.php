<?php

namespace App\Notification\Models;


use App\Account\Models\User;
use Illuminate\Database\Eloquent\Model;


class Notifications extends Model
{

    protected $table = 'notifications';

    protected $guarded = [''];


    public function user()
    {
        return $this->belongsTo(User::class,'userId');
    }

}
