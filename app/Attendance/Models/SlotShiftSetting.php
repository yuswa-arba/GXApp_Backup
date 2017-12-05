<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class SlotShiftSetting extends Model
{
    protected $table='slotShiftSetting';
    protected $fillable = [
        'name',
        'slotId',
        'shiftId',
        'week',
        'month',
        'year',
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
