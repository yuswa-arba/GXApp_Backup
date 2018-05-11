<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceGeofence extends Model
{
    protected $table = 'attendanceGeofence';
    protected $fillable = [
        'latitude',
        'longitude',
        'radius',
        'description'
    ];
}
