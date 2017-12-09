<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeSlotSchedule extends Model
{
    protected $table='employeeSlotSchedule';
    protected $fillable = [
        'employeeId',
        'slotId',
        'setBy',
        'setAt'
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
