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
            'availableForAssign' => $this->isAvailableForAssign($slots),
            'isUsingMapping' =>$slots->isUsingMapping
        ];
    }

    private function isAvailableForAssign($slots)
    {
        // if its not allow multiple assign and has already at least one return false
        if (!$slots->allowMultipleAssign && count($slots->slotSchedule) > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function assignedTo($slots)
    {
        $assignedTo = array();
        $assignedTo['total'] = count($slots->slotSchedule);

        // if value is only one return employee name
        if (count($slots->slotSchedule) == 1) {
            // get employee data
            if ($slots->employees) {
                // if found return employee name
                $assignedTo['name'] = $slots->employees[0]->givenName.' '.$slots->employees[0]->surname;
            }
        }

        return $assignedTo;
    }
}
