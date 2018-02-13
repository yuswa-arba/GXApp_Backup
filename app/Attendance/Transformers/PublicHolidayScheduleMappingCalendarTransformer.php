<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\PublicHoliday;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class PublicHolidayScheduleMappingCalendarTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(PublicHolidaySchedule $publicHolidaySchedule)
    {
        return [
            'id' => $publicHolidaySchedule->id,
            'title' => $this->getResultWithNullChecker1Connection($publicHolidaySchedule,'publicHoliday','name'),
            'start' => Carbon::createFromFormat('d/m/Y', $publicHolidaySchedule->applyDate)->format('Y-m-d'),
            'slotId'=>$publicHolidaySchedule->fromSlotId,
            'className' => 'calendar-cell-sm  bold red-border-2',
            'textColor' => '#fff',
            'eventType' => 'publicHoliday'
        ];
    }

}
