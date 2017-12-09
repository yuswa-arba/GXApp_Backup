<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class Slots extends Model
{
    protected $table='slots';
    protected $fillable = [
        'name',
        'positionOrder',
        'allowMultipleAssign',
        'slotMakerId',
    ];

    protected $casts = [
        'allowMultipleAssign' => 'boolean'
    ];

    public function slotMaker()
    {
        return $this->belongsTo(SlotMaker::class,'slotMakerId');
    }

    public function employees()
    {
        return $this->belongsToMany(MasterEmployee::class,'employeeSlotSchedule','slotId','employeeId');
    }

    public function slotSchedule()
    {
        return $this->hasMany(EmployeeSlotSchedule::class,'slotId');
    }
}
