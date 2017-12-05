<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class EmployeeSlotSchedule extends Model
{
    protected $table='employeeSlotSchedule';
    protected $fillable = [
        'employeeId',
        'slotId',
    ];

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function slot()
    {
        return $this->belongsTo(Slots::class,'slotId');
    }
}
