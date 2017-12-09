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
            'name' => $employees->givenName . ' ' . $employees->surname,
            'jobPosition' => $employees->employment->jobPosition->name,
            'hasSlotSchedule' => is_null($employees->slotSchedule) ? false : true,
            'slotSchedule' => $this->slotSchedule($employees)
        ];
    }

    private function slotSchedule($employees)
    {
        if ($employees->slotSchedule) {
            $slot = $employees->slotSchedule->slot;
            return ['id' => $slot->id, 'name' => $slot->name];
        } else {
            return '';
        }

    }
}
