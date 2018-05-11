<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\PublicHoliday;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class EmployeeLeaveScheduleSingleCalendarAPITransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(EmployeeLeaveSchedule $employeeLeaveSchedule)
    {
        return [
            'id' => $employeeLeaveSchedule->id,
            'title' => $employeeLeaveSchedule->description,
            'startDate' => $employeeLeaveSchedule->fromDate,
            'endDate' =>$employeeLeaveSchedule->toDate,
            'isStreakPaidLeave'=>$employeeLeaveSchedule->isStreakPaidLeave

        ];
    }

}
