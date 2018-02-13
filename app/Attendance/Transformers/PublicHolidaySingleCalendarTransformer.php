<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\PublicHoliday;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class PublicHolidaySingleCalendarTransformer extends TransformerAbstract
{

    public function transform(PublicHoliday $publicHolidaySchedule)
    {
        return [
            'id' => $publicHolidaySchedule->id,
            'title' => 'Holiday: '.$publicHolidaySchedule->name,
            'start' => Carbon::createFromFormat('d/m/Y', $publicHolidaySchedule->date)->format('Y-m-d'),
            'className'=> 'bg-danger-light calendar-cell text-white',
            'eventType' => 'publicHoliday'
        ];
    }

}
