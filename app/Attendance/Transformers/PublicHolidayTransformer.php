<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class PublicHolidayTransformer extends TransformerAbstract
{
    use GlobalUtils;


    public function transform(PublicHolidaySchedule $holidaySchedule)
    {
        return [
            'id' => $holidaySchedule->id,
            'name' =>$holidaySchedule->name,
            'date' =>$holidaySchedule->date,
            'isGeneral'=>$holidaySchedule->isGeneral,
            'religionId'=>$holidaySchedule->religionId,
            'religionName'=>$this->getResultWithNullChecker1Connection($holidaySchedule,'religion','name'),
            'onYear'=>$holidaySchedule->onYear,
            'isApplied'=>$holidaySchedule->isApplied
        ];
    }


}
