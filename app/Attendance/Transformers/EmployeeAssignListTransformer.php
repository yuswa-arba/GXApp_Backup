<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class EmployeeAssignListTransformer extends TransformerAbstract
{
    public function transform($employees)
    {
        return [
            'id' => $employees->id,
            'employeeNo' => $employees->employeeNo,
            'name' => $employees->givenName . ' ' .$employees->surname,
            'jobPosition' => $employees->employment->jobPosition->name,
            'hasSlotSchedule' => is_null($employees->slotSchedule) ? false : true,
            'slotSchedule' => !is_null($employees->slotSchedule) ? $employees->slotSchedule->slot->name : ''
        ];
    }
}
