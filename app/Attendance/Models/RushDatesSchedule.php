<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class RushDatesSchedule extends Model
{
    protected $table='rushDatesSchedule';
    protected $fillable=[
        'date',
        'startTime',
        'endTime',
        'allDay',
        'description',
    ];
}
