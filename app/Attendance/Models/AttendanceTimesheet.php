<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceTimesheet extends Model
{
    protected $table='attendanceTimesheet';
    protected $guarded = [];

    public function attenndanceSchedule()
    {
        return $this->belongsTo(AttendanceSchedule::class,'attendanceScheduleId');
    }

    public function attendanceViaType()
    {
        return $this->belongsTo(AttendanceViaType::class,'attendanceViaTypeId');
    }

    public function kiosk()
    {
        return $this->belongsTo(Kiosks::class,'kioskId');
    }

    public function attendanceValidation()
    {
        return $this->belongsTo(AttendanceValidation::class,'attendanceValidationId');
    }



}
