<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ShiftScheduleMappingCalendarTransformer extends TransformerAbstract
{

    public function transform(SlotShiftSchedule $slotShiftSchedule)
    {
        return [
            'id' => $slotShiftSchedule->id,
            'title' => 'Shift: '.$slotShiftSchedule->shift->name,
            'start' => Carbon::createFromFormat('d/m/Y', $slotShiftSchedule->date)->format('Y-m-d').'T'.$slotShiftSchedule->shift->workStartAt,
            'end' => $this->getEndDate($slotShiftSchedule),
            'slotId' => $slotShiftSchedule->slotId,
            'shiftId' => $slotShiftSchedule->shiftId,
            'className' => 'calendar-cell-sm no-border cursor',
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
