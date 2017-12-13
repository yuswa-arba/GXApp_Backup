<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\SlotMaker;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class SlotMakerListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(SlotMaker $slotMaker)
    {
        return [
            'id' => $slotMaker->id,
            'name' => $slotMaker->name,
            'firstDate' => $slotMaker->firstDate,
            'relatedToJobPosition'=>$slotMaker->relatedToJobPosition,
            'jobPositionId'=>$slotMaker->jobPositionId,
            'jobPosition'=>!is_null($slotMaker->jobPosition)?$slotMaker->jobPosition->name:'',
            'totalDayLoop' => $slotMaker->totalDayLoop,
            'workingDays' => $slotMaker->workingDays,
            'allowMultipleAssign' =>$slotMaker->allowMultipleAssign,
            'isExecuted' =>$slotMaker->isExecuted,
            'executedAt' => Carbon::parse($slotMaker->executedAt)->diffForHumans(),
            'executedBy' =>$slotMaker->executedBy,
        ];
    }
}
