<?php

namespace App\Account\Models;

use App\Account\Notifications\ResetPasswordNotification;
use App\Account\Traits\Utils;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Notification\Models\Notifications;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

    protected $table = 'users';
    public $incrementing = false;


    protected $guarded = [''];


    protected $hidden = [
        'password', 'remember_token',
    ];

//    protected $casts = [
//        'allowAdminAccess'=>'boolean',
//        'allowSuperAdminAccess' => 'boolean'
//    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function employment()
    {
        return $this->belongsTo(Employment::class,'employeeId');
    }

    public function accessStatus()
    {
        return $this->belongsTo(AccessStatus::class,'accessStatusId');
    }

    public function pushToken()
    {
        return $this->hasMany(UserPushToken::class,'userId');
    }

    public function pushNotifications()
    {
        return $this->hasMany(Notifications::class,'userId');
    }

}
