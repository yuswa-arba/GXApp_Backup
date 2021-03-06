<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class AttendanceTimesheet extends Model
{
    protected $table='attendanceTimesheet';
    protected $guarded = [];

    public function attenndanceSchedule()
    {
        return $this->belongsTo(AttendanceSchedule::class,'attendanceScheduleId');
    }

    public function clockInKiosk()
    {
        return $this->belongsTo(Kiosks::class,'clockInKioskId');
    }

    public function clockOutKiosk()
    {
        return $this->belongsTo(Kiosks::class,'clockOutKioskId');
    }

    public function attendanceValidation()
    {
        return $this->belongsTo(AttendanceValidation::class,'attendanceValidationId');
    }

    public function attendanceApproval()
    {
        return $this->belongsTo(AttendanceApproval::class,'attendanceApproveId');

    }

    public function shift()
    {
        return $this->belongsTo(Shifts::class,'shiftId');
    }

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }


}
