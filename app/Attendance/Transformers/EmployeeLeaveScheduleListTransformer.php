<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class EmployeeLeaveScheduleListTransformer extends TransformerAbstract
{

    use GlobalUtils;

    public function transform(EmployeeLeaveSchedule $els)
    {
        return [
            'id' => $els->id,
            'employeeId'=>$els->employeeId,
            'employeeName'=>$this->getResultWithNullChecker1Connection($els,'employee','givenName'), // same with $els->employee->givenName
            'employeeDivisionId'=>$this->getResultWithNullChecker3Connection($els,'employee','employment','division','id'), // same with $els->employee->employment->division->name
            'employeeDivisionName'=>$this->getResultWithNullChecker3Connection($els,'employee','employment','division','name'), // same with $els->employee->employment->division->name
            'fromDate'=>$els->fromDate,
            'toDate'=>$els->toDate,
            'totalDays'=>$els->totalDays,
            'isStreakPaidLeave'=>$els->isStreakPaidLeave,
            'year'=>$els->year,
            'leaveApprovalId'=>$els->leaveApprovalId,
            'leaveApprovalName'=>$this->getResultWithNullChecker1Connection($els,'leaveApproval','name'),
            'leaveTypeId'=>$els->leaveTypeId,
            'leaveTypeName'=>$this->getResultWithNullChecker1Connection($els,'leaveType','name'),
            'description'=>$els->description,
            'answer'=>$els->answer,
            'answeredBy'=>$els->answeredBy
        ];
    }




}
