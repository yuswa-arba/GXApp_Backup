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
        //include jobPosition in slotMaker
        !is_null($slots->slotMaker->jobPosition) ? $slots->slotMaker->jobPosition : '';

        return [
            'id' => $slots->id,
            'name' => $slots->name,
            'positionOrder' => $slots->positionOrder,
            'allowMultipleAssign' => $slots->allowMultipleAssign,
            'slotMaker' => $slots->slotMaker,
            'assignedTo' => $this->assignedTo($slots),
            'availableForAssign' => $this->isAvailableForAssign($slots)
        ];
    }

    private function isAvailableForAssign($slots)
    {
        // if its not allow multiple assign and has already at least one return false
        if (!$slots->allowMultipleAssign && count($slots->employeeSlotSchedule) > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function assignedTo($slots)
    {
        // if value is only one return employee name
        if (count($slots->employeeSlotSchedule) == 1) {
            // get employee data
            if ($slots->employeeSlotSchedule->employee) {
                // if found return employee name
                return $slots->employeeSlotSchedule->employee->givenName;
            } else {
                // if failed return count value
                return count($slots->employeeSlotSchedule);
            }
        } else {
            // return count value
            return count($slots->employeeSlotSchedule);
        }
    }
}
