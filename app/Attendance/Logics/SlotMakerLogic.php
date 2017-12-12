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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SlotMakerLogic extends ExecuteUseCase
{

    public function handleExecution($request)
    {

        $response = array();
        $slotMaker = SlotMaker::where('id', $request->get('id'))->where('isExecuted', '!=', 1)->first();

        if ($slotMaker) {

            $execute = $this->createDayOffSlots($slotMaker)->updateSlotMaker($slotMaker);

            if ($execute) {

                /* Return success response */
                $response['isFailed'] = false;
                $response['message'] = 'Slot has been executed successfully';
                $response['slotMakers'] = SlotMaker::all();
                return response()->json($response, 200);

            } else {

                /* Delete all data inserted during execution */
                $getSlot = Slots::where('slotMakerId', $slotMaker->id)->first();
                DayOffSchedule::where('slotId', $getSlot->id)->delete();
                Slots::where('id', $getSlot->id)->delete();

                /* Return error response */
                $response['isFailed'] = true;
                $response['message'] = 'Failed! Error during execution';
                return response()->json($response, 500);

            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to execute slot maker, undefined slot maker';
            return response()->json($response, 500);
        }

    }

    private function createDayOffSlots($slotMaker)
    {
        $maxLoopDay = $slotMaker->totalDayLoop;
        $workinDay = $slotMaker->workingDays;
        $totalDaysInThisYear = (365 + Carbon::now()->format('L'));

        for ($i = 0; $i < $maxLoopDay; $i++) {

            $dayOffs = array();

            $slot = $this->createSlot($slotMaker, $i + 1);

            $w = 1;
            for ($d = $totalDaysInThisYear; $d > 7; $d -= 6) {
                $week = $w++;

                $date = Carbon::createFromFormat('d/m/Y', $slotMaker->firstDate)->addDays($i + ($workinDay + 1) * $week)->format('d/m/Y');

                // Check if date is in current year
                if (Carbon::createFromFormat('d/m/Y', $date)->year == Carbon::now()->year) {
                    array_push($dayOffs, array('slotId' => $slot->id, 'date' => $date, 'description' => 'Weekly Day Off'));
                }
            }

            // add first day off
            $firstDayOff = Carbon::createFromFormat('d/m/Y', $slotMaker->firstDate)->addDays($i)->format('d/m/Y');

            // Check if date is in current year
            if (Carbon::createFromFormat('d/m/Y', $firstDayOff)->year == Carbon::now()->year) {
                array_push($dayOffs, array('slotId' => $slot->id, 'date' => $firstDayOff, 'description' => 'Weekly Day Off'));
            }

            // add missing working days
            if($i+1 > $workinDay){
                for ($m=$i+1 ;$m > 0 ; $m-=$workinDay+1){

                    $date = Carbon::createFromFormat('d/m/Y', $slotMaker->firstDate)->addDays($m-1);

                    if($date->day!=$i+1){
                        if (Carbon::createFromFormat('d/m/Y', $date->format('d/m/Y'))->year == Carbon::now()->year) {
                            array_push($dayOffs, array('slotId' => $slot->id, 'date'=>$date->format('d/m/Y'), 'description' => 'Weekly Day Off'));
                        }
                    }
                }
            }



            DayOffSchedule::insert($dayOffs);
        }

        return $this;
    }

    private function createSlot($slotMaker, $positionOrder)
    {
        Slots::updateOrCreate(
            ['name' => str_replace(" ", "", $slotMaker->name) . "_" . $positionOrder, 'slotMakerId' => $slotMaker->id, 'positionOrder' => $positionOrder],
            ['allowMultipleAssign' => $slotMaker->allowMultipleAssign]
        );

        $slot = Slots::where('name', str_replace(" ", "", $slotMaker->name) . "_" . $positionOrder)
            ->where('slotMakerId', $slotMaker->id)
            ->where('positionOrder', $positionOrder)
            ->first();

        return $slot;
    }

    private function updateSlotMaker($slotMaker)
    {
        return SlotMaker::where('id', $slotMaker->id)
            ->update(['isExecuted' => 1, 'executedAt' => Carbon::now(), 'executedBy' => !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '']);
    }
}