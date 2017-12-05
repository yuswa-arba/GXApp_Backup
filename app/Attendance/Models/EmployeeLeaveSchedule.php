<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveSchedule extends Model
{
    protected $table='employeeLeaveSchedule';
    protected $fillable = [
        'employeeId',
        'leaveTypeId',
        'description',
        'leaveApprovalId',
    ];

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }
}
