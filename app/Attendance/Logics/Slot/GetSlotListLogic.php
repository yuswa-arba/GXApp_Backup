<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Slot;

use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use App\Traits\GlobalUtils;

class GetSlotListLogic extends GetSlotDataUseCase
{
    use GlobalUtils;

    /*
     * @description : get Slots where it is created on current year / all, and its not deleted
     * */

    public function handleGetAllSlot($request)
    {
        $getOnlyCurrentYear = false;
        if($request->getOnlyCurrentYear==1){
            $getOnlyCurrentYear = true;
        }

        if ($getOnlyCurrentYear) {
            $slots = Slots::whereYear('created_at', $this->currentYear())->orWhere('id', 1)->where('isDeleted','!=',1)->get();
        } else {
            $slots = Slots::orderBy('created_at', 'desc')->where('isDeleted','!=',1)->get();
        }

        return fractal($slots, new SlotListTransformer())->respond(200);
    }

    public function handleStatusAndRelation($request)
    {
        $getOnlyCurrentYear = false;
        if($request->getOnlyCurrentYear==1){
            $getOnlyCurrentYear = true;
        }
        $slots = $this->getSlotByStatusAndRelation($request->get('statusBy'), $request->get('relatedBy'), $getOnlyCurrentYear);
        return fractal($slots, new SlotListTransformer())->respond(200);
    }

    public function handleSlotWithSpecificStatus($request)
    {
        $getOnlyCurrentYear = false;
        if($request->getOnlyCurrentYear==1){
            $getOnlyCurrentYear = true;
        }
        $slots = $this->getSlotBySpecificStatus($request->get('statusBy'), $getOnlyCurrentYear);
        return fractal($slots, new SlotListTransformer())->respond(200);
    }

    public function handleSlotWithSpecificRelation($request)
    {
        $getOnlyCurrentYear = false;
        if($request->getOnlyCurrentYear==1){
            $getOnlyCurrentYear = true;
        }
        $slots = $this->getSlotBySpecificRelation($request->get('relatedBy'), $getOnlyCurrentYear);
        return fractal($slots, new SlotListTransformer())->respond(200);
    }

    private function getSlotByStatusAndRelation($statusBy, $relatedBy, $getOnlyCurrentYear)
    {

        $assignedSlotsId = array();
        $slots = Slots::all();

        foreach ($slots as $slot) {
            if (count($slot->employees) > 0) {
                array_push($assignedSlotsId, $slot->id);
            }
        }


        switch ($statusBy) {

            case 'assigned':

                if (!count($assignedSlotsId) > 0) {
                    return null;
                }


                $filterSlotIds = array();
                $slotWhereIn = Slots::whereIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlotsRelation($slotWhereIn, $relatedBy));


                if ($getOnlyCurrentYear) {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->whereYear('created_at', $this->currentYear())->get();
                } else {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->get();
                }

                break;

            case 'unassigned':
                $filterSlotIds = array();
                $slotWhereNotIn = Slots::whereNotIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlotsRelation($slotWhereNotIn, $relatedBy));

                if ($getOnlyCurrentYear) {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->whereYear('created_at', $this->currentYear())->get();
                } else {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->get();
                }

                break;
            default:
                break;
        }

        return $slots;

    }

    private function getSlotBySpecificStatus($statusBy, $getOnlyCurrentYear)
    {
        $assignedSlotsId = array();
        $slots = Slots::all();

        foreach ($slots as $slot) {
            if (count($slot->employees) > 0) {
                array_push($assignedSlotsId, $slot->id);
            }
        }


        switch ($statusBy) {

            case 'assigned':

                if (!count($assignedSlotsId) > 0) {
                    return null;
                }

                $filterSlotIds = array();
                $slotWhereIn = Slots::whereIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlots($slotWhereIn));

                if ($getOnlyCurrentYear) {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->whereYear('created_at', $this->currentYear())->get();
                } else {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->get();
                }

                break;
            case 'unassigned':
                $filterSlotIds = array();
                $slotWhereNotIn = Slots::whereNotIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlots($slotWhereNotIn));

                if ($getOnlyCurrentYear) {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->whereYear('created_at', $this->currentYear())->get();
                } else {
                    $slots = Slots::whereIn('id', $filterSlotIds[0])->get();
                }

                break;

            default:
                break;
        }

        return $slots;

    }

    private function getSlotBySpecificRelation($relatedBy, $getOnlyCurrentYear)
    {
        $filterSlotIds = array();
        $slots = Slots::all();

        array_push($filterSlotIds, $this->filterSlotsRelation($slots, $relatedBy));

        if($getOnlyCurrentYear){
            $slots = Slots::whereIn('id', $filterSlotIds[0])->whereYear('created_at',$this->currentYear())->get();
        } else{
            $slots = Slots::whereIn('id', $filterSlotIds[0])->get();
        }

        return $slots;
    }

    private function filterSlotsRelation($slots, $relatedBy)
    {
        $filteredSlotIds = array();
        foreach ($slots as $slot) {
            if ($slot->slotMaker->relatedToJobPosition && $slot->slotMaker->jobPositionId == $relatedBy) {
                array_push($filteredSlotIds, $slot->id);
            }
        }

        return $filteredSlotIds;
    }

    private function filterSlots($slots)
    {
        $filteredSlotIds = array();
        foreach ($slots as $slot) {
            array_push($filteredSlotIds, $slot->id);
        }
        return $filteredSlotIds;
    }


}