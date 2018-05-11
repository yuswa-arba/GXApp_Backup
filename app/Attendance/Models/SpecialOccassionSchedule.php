<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialOccassionSchedule extends Model
{
    protected $table='specialOccassionSchedule';
    protected $fillable = [
        'date',
        'startTime',
        'endTime',
        'allDay',
        'description',
    ];
}
