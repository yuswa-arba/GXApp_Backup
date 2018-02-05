<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ShiftScheduleSingleCalendarAPITransformer extends TransformerAbstract
{
    use GlobalUtils;
    public function transform(SlotShiftSchedule $slotShiftSchedule)
    {
        return [
            'id' => $slotShiftSchedule->id,
            'title' => 'Shift: '.$this->getResultWithNullChecker1Connection($slotShiftSchedule,'shift','workEndAt'),
            'startDate' => Carbon::createFromFormat('d/m/Y', $slotShiftSchedule->date)->format('d/m/Y'),
            'startTime' => $this->getResultWithNullChecker1Connection($slotShiftSchedule,'shift','workStartAt'),
            'endDate' => $this->getEndDate($slotShiftSchedule),
            'endTime'=>$this->getResultWithNullChecker1Connection($slotShiftSchedule,'shift','workEndAt'),
            'slotId' => $slotShiftSchedule->slotId,
            'shiftId' => $slotShiftSchedule->shiftId,
        ];
    }

    private function getEndDate($slotShiftSchedule)
    {
        if($slotShiftSchedule->shift->isOvernight){
            // add one day if its overnight
            return Carbon::createFromFormat('d/m/Y', $slotShiftSchedule->date)->addDay()->format('d/m/Y');
        }

        return Carbon::createFromFormat('d/m/Y', $slotShiftSchedule->date)->format('d/m/Y');
    }
}
