<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class EmployeeLeaveScheduleListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(EmployeeLeaveSchedule $els)
    {
        return [
            'id' => $els->id,
            'employeeId'=>$els->employeeId,
            'fromDate'=>$els->fromDate,
            'toDate'=>$els->toDate,
            'leaveApprovalId'=>$els->leaveApprovalId,
            'leaveApprovalName'=>!is_null($els->leaveApproval)?$els->leaveApproval->name:'',
            'leaveTypeId'=>$els->leaveTypeId,
            'leaveTypeName'=>!is_null($els->leaveType)?$els->leaveType->name:'',
            'description'=>$els->description,
            'answer'=>$els->answer,
            'answeredBy'=>$els->answeredBy
        ];
    }
    
}
