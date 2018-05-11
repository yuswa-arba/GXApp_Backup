<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Slot;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;

class CopySlotLogic extends CopySlotUseCase
{
    use GlobalUtils;


    /*
     * @body : copyFromSlotId (int) , name (string), addBy (int)
     * @description : copy slots from an existing one and add by specific day,
     *                if not it will be duplicated
     *
     * */
    public function handleCopy($formRequest)
    {
        $slot = Slots::find($formRequest->copyFromSlotId);
        if ($slot) {

            $copy = Slots::create([
                'name' => $formRequest->name,
                'positionOrder' => $slot->positionOrder + 1,
                'alllowMultipleAssign' => $slot->alllowMultipleAssign,
                'slotMakerId' => $slot->slotMakerId,
                'isUsingMapping' => $slot->isUsingMapping
            ]);

            if ($copy) {

                if ($this->copyDayOffSlots($slot->id, $copy->id, $formRequest->addBy)) {

                    $response['isFailed'] = false;
                    $response['message'] = 'Slot has been copied successfully';
                    $response['copiedSlot'] = fractal($copy, new SlotListTransformer());
                    return response()->json($response, 200);

                } else {
                    $response['isFailed'] = true;
                    $response['message'] = 'Unable to create day offs of copied slot';
                    return response()->json($response, 200);
                }

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to copy slot';
                return response()->json($response, 200);
            }

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Slot not found';
            return response()->json($response, 200);
        }
    }


    private function copyDayOffSlots($slotId, $copySlotId, $addBy)
    {
        $dayOffs = DayOffSchedule::select('date', 'description')->where('slotId', $slotId)->get();
        if (count($dayOffs) > 0) {
            $copyOfDaysOffs = array();

            foreach ($dayOffs as $dayOff) {

                if ($addBy != 0) {
                    $dayOffDate = Carbon::createFromFormat('d/m/Y', $dayOff->date)->addDays($addBy)->format('d/m/Y');
                } else {
                    $dayOffDate = Carbon::createFromFormat('d/m/Y', $dayOff->date)->format('d/m/Y');
                }

                array_push($copyOfDaysOffs, array('slotId' => $copySlotId, 'date' => $dayOffDate, 'description' => $dayOff->description));
            }

            if (DayOffSchedule::insert($copyOfDaysOffs)) {
                return true;
            } else {
                return false;
            }

        } else {
            return true;
        }
    }

}