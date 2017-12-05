<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceValidation extends Model
{
    protected $table='attendanceValidation';
    protected $fillable = [
        'name'
    ];


}
