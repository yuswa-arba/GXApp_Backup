<?php

namespace App\Employee\Models;

use App\Account\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MasterEmployee extends Model
{
    use Notifiable;

    protected $table = 'MasterEmployee';
    public $incrementing = false;

//    protected $guarded = ['id','employeeNo'];
    protected $guarded = [''];


    public function dataVerification()
    {
        return $this->hasMany(EmployeeDataVerification::class,'employeeId','id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'employeeId','id');
    }

    public function employment()
    {
        return $this->hasOne(Employment::class,'employeeId','id');
    }

}
