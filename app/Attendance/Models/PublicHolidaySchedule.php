<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class PublicHolidaySchedule extends Model
{
    protected $table='publicHolidaySchedule';
    protected $fillable =[
        'date',
        'name',
        'isGeneral',
        'religionId',
    ];
}
