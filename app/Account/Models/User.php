<?php

namespace App\Account\Models;

use App\Account\Traits\Utils;
use App\Account\Traits\Uuids;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $table = 'users';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employeeId',
        'userLevelId',
        'accessStatusId',
        'email',
        'password',
        'allowSuperAdminAccess',
        'allowAdminAccess',
        'allowUserAccess',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
