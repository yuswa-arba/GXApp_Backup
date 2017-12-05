<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceApproval extends Model
{
    protected $table='attendanceApproval';
    protected $fillable = [
        'name'
    ];
}
