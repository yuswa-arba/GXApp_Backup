<?php

namespace App\Account\Models;

use App\Account\Traits\Utils;
use App\Account\Traits\Uuids;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
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
}
