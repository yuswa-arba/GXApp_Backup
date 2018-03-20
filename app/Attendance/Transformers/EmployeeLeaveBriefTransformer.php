<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class EmployeeLeaveBriefTransformer extends TransformerAbstract
{

    use GlobalUtils;

    public function transform(EmployeeLeaveSchedule $els)
    {
        return [
            'id' => $els->id,
            'fromDate'=>$els->fromDate,
            'toDate'=>$els->toDate,
            'totalDays'=>$els->totalDays,
            'month'=>$els->month,
            'year'=>$els->year,
            'leaveApprovalId'=>$els->leaveApprovalId,
            'leaveApprovalName'=>$this->getResultWithNullChecker1Connection($els,'leaveApproval','name'),
            'leaveTypeId'=>$els->leaveTypeId,
            'leaveTypeName'=>$this->getResultWithNullChecker1Connection($els,'leaveType','name'),
            'description'=>$els->description,
            'isStreakPaidLeave'=>$els->isStreakPaidLeave,
            'answer'=>$els->answer,
            'answeredBy'=>$els->answeredBy,
        ];
    }




}
