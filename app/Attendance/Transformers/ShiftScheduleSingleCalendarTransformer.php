<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ShiftScheduleSingleCalendarTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(SlotShiftSchedule $slotShiftSchedule)
    {
        return [
            'id' => $slotShiftSchedule->id,
            'title' => 'Shift: '.$slotShiftSchedule->shift->name,
            'start' => Carbon::createFromFormat('d/m/Y', $slotShiftSchedule->date)->format('Y-m-d').'T'.$slotShiftSchedule->shift->workStartAt,
            'end' => $this->getEndDate($slotShiftSchedule),
            'slotId' => $slotShiftSchedule->slotId,
            'shiftId' => $slotShiftSchedule->shiftId,
            'className'=> 'bg-primary calendar-cell text-white',
//            'backgroundColor'=>'',
            'textColor' => '#fff',
            'eventType' => 'shiftSchedule'
        ];
    }

    private function getEndDate($slotShiftSchedule)
    {
        if($slotShiftSchedule->shift->isOvernight){
            // add one day if its overnight
            return Carbon::createFromFormat('d/m/Y', $slotShiftSchedule->date)->addDay()->format('Y-m-d').'T'.$slotShiftSchedule->shift->workEndAt;
        }

        return Carbon::createFromFormat('d/m/Y', $slotShiftSchedule->date)->format('Y-m-d').'T'.$slotShiftSchedule->shift->workEndAt;
    }
}
