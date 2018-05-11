<?php

namespace App\Attendance\Models;


use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class TakenDayOffs extends Model
{
    protected $table = 'takenDayOffs';
    protected $fillable = [
        'employeeId',
        'dayOffScheduleId',
        'takenCause',
        'isTakenApproved',
        'takenBy',
        'takenAt',
        'changedDate',
        'isChangedDateApproved',
        'approvedBy',
        'approvedAt',
    ];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function dayOffSchedule()
    {
        return $this->belongsTo(DayOffSchedule::class,'dayOffScheduleId');
    }

}
