<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class SlotListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Slots $slots)
    {
        return [
            'id' => $slots->id,
            'name' => $slots->name,
            'positionOrder' => $slots->positionOrder,
            'allowMultipleAssign' =>$slots->allowMultipleAssign,
            'slotMaker' =>$slots->slotMaker
        ];
    }
}
