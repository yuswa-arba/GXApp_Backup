<?php

namespace App\Account\Models;

use App\Account\Traits\Utils;
use App\Account\Traits\Uuids;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class PushNotifications extends Model
{

    protected $table = 'pushNotifications';
    public $incrementing = false;


    protected $guarded = [''];


    public function user()
    {
        return $this->belongsTo(User::class,'userId');
    }

}
