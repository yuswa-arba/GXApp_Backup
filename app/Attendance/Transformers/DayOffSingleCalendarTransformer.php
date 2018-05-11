<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class DayOffSingleCalendarTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(DayOffSchedule $dayOffSchedule)
    {
        return [
            'id' => $dayOffSchedule->id,
            'title' => $dayOffSchedule->description,
            'start' => Carbon::createFromFormat('d/m/Y',$dayOffSchedule->date)->format('Y-m-d'),
//            'start' => $dayOffSchedule->date,
            'className'=> 'bg-danger calendar-cell text-white',
        ];
    }
}
