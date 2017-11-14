<?php

namespace App\Employee\Models;

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

}
