<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    protected $table = 'shiftSchedule';

    protected $fillable = [
        'name',
        'timeStart',
        'timeEnd',
        'isOvernight'
    ];

}
