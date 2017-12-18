<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSchedule extends Model
{
    protected $table = 'attendanceSchedule';
    protected $fillable = [
        'shiftId',
        'allowedToCheckIn',
        'allowedToCheckOut',
        'allowedToBreakIn',
        'allowedToBreakOut'
    ];

    public function slot()
    {
        return $this->belongsTo(Slots::class,'slotId');
    }

    public function shift()
    {
        return $this->belongsTo(Shifts::class,'shiftId');
    }


}
