<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class DayOffSchedule extends Model
{
    protected $table = 'dayOffSchedule';
    protected $fillable = [
        'slotId',
        'date',
        'description',
    ];

    public function slot()
    {
        return $this->belongsTo(Slots::class,'slotId');
    }
}
