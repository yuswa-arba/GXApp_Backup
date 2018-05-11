<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class SlotShiftSchedule extends Model
{
    protected $table='slotShiftSchedule';
    protected $fillable = [
        'slotId',
        'shiftId',
        'date',
        'isOverwrite'
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
