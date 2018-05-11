<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    protected $table='attendanceSetting';
    protected $fillable = [
        'param',
        'value',
        'description',
    ];
}
