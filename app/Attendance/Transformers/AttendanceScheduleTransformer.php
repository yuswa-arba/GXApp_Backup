<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AttendanceScheduleTransformer extends TransformerAbstract
{
    use GlobalUtils;


    public function transform(Shifts $shifts)
    {
        return [
            'shiftId' => $shifts->id,
            'shiftName' =>$shifts->name,
            'workStartAt' =>$shifts->workStartAt,
            'workEndAt'=>$shifts->workEndAt,
            'isOvernight'=>$shifts->isOvernight,
            'allowToCheckIn'=>$this->getAllowToCheckInStats($shifts->id),
            'allowToCheckOut'=>$this->getAllowToCheckOutStats($shifts->id)
        ];
    }

    private function getAllowToCheckInStats($id)
    {
        return AttendanceSchedule::where('shiftId',$id)->first()['allowedToCheckIn'];
    }

    private function getAllowToCheckOutStats($id)
    {
        return AttendanceSchedule::where('shiftId',$id)->first()['allowedToCheckOut'];
    }


}
