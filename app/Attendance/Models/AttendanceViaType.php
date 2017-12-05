<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceViaType extends Model
{
    protected $table='attendanceViaType';
    protected $fillable = [
        'name'
    ];
}
