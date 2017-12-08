<?php

namespace App\Employee\Models;

use App\Account\Models\User;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Components\Models\Bank;
use App\Components\Models\EducationLevel;
use App\Components\Models\MaritalStatus;
use App\Components\Models\Religion;
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
        return $this->hasMany(EmployeeDataVerification::class, 'employeeId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'employeeId');
    }

    public function employment()
    {
        return $this->hasOne(Employment::class, 'employeeId');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religionId');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'educationLevelId');
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'maritalStatusId');
    }

    public function fatherMaritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'fatherMaritalStatusId');
    }

    public function motherMaritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class,'motherMaritalStatusId');
    }

    public function siblingMaritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class,'siblingMaritalStatusId');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bankId');
    }

    public function slotSchedule()
    {
        return $this->hasOne(EmployeeSlotSchedule::class,'employeeId');
    }

}
