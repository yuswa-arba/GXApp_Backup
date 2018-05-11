<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveSchedule extends Model
{
    protected $table='employeeLeaveSchedule';

    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function leaveApproval()
    {
        return $this->belongsTo(LeaveApproval::class,'leaveApprovalId');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class,'leaveTypeId');
    }
}
