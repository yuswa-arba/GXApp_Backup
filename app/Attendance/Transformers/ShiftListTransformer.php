<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ShiftListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Shifts $shifts)
    {
        return [
            'id' => $shifts->id,
            'name' => $shifts->name,
            'workStartAt' => $shifts->workStartAt,
            'workEndAt' => $shifts->workEndAt,
            'breakStartAt' => $shifts->breakStartAt,
            'breakEndAt' => $shifts->breakEndAt,
            'isOvernight' => $shifts->isOvernight,
        ];
    }
}
