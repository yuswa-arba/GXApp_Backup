<?php

namespace App\Components\Transformers;

use App\Attendance\Models\SlotMaker;
use App\Components\Models\JobPosition;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class JobPositionListTransfomer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(JobPosition $jobPosition)
    {
        return [
            'id' => $jobPosition->id,
            'name' => $jobPosition->name,
        ];
    }
}
