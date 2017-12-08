<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetSlotListLogic extends GetSlotListUseCase
{

    public function handle($request)
    {
        $byAllStatus = true;
        $byAllRelated = true;

        if ($request->get('relatedBy') != '') {
            $byAllRelated = false;
        }

        if ($request->get('statusBy') != '') {
            $byAllStatus = false;
        }

        // all slots
        $slots = Slots::all();

        // by specific status, by specific job position relation
        if (!$byAllStatus && !$byAllRelated) {
            $slots = $this->getSlotByStatusAndRelation($request->get('statusBy'), $request->get('relatedBy'));
        }

        // by specific status , by all related
        if (!$byAllStatus && $byAllRelated) {
            $slots = $this->getSlotBySpecificStatus($request->get('statusBy'));
        }

        // by specific job position relation ,  by all status
        if (!$byAllRelated && $byAllStatus) {
            $slots = $this->getSlotBySpecificRelation($request->get('relatedBy'));
        }

        // by default return all slots
        return fractal($slots, new SlotListTransformer())->respond(200);
    }

    private function getSlotByStatusAndRelation($statusBy, $relatedBy)
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

                if (!count($assignedSlotsId)>0){
                    return null;
                }


                $filterSlotIds = array();
                $slotWhereIn = Slots::whereIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlotsRelation($slotWhereIn, $relatedBy));

                $slots = Slots::whereIn('id', $filterSlotIds[0])->get();

                break;
            case 'unassigned':
                $filterSlotIds = array();
                $slotWhereNotIn = Slots::whereNotIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlotsRelation($slotWhereNotIn, $relatedBy));

                $slots = Slots::whereIn('id', $filterSlotIds[0])->get();

                break;
            default:
                break;
        }

        return $slots;

    }

    private function getSlotBySpecificStatus($statusBy)
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

                if (!count($assignedSlotsId)>0){
                    return null;
                }

                $filterSlotIds = array();
                $slotWhereIn = Slots::whereIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlots($slotWhereIn));

                $slots = Slots::whereIn('id', $filterSlotIds[0])->get();

                break;
            case 'unassigned':
                $filterSlotIds = array();
                $slotWhereNotIn = Slots::whereNotIn('id', $assignedSlotsId)->get();

                array_push($filterSlotIds, $this->filterSlots($slotWhereNotIn));


                $slots = Slots::whereIn('id', $filterSlotIds[0])->get();

                break;

            default:
                break;
        }

        return $slots;

    }

    private function getSlotBySpecificRelation($relatedBy)
    {
        $filterSlotIds = array();
        $slots = Slots::all();

        array_push($filterSlotIds, $this->filterSlotsRelation($slots, $relatedBy));


        $slots = Slots::whereIn('id', $filterSlotIds[0])->get();

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