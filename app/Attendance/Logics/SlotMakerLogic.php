<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\SlotMaker;
use Carbon\Carbon;

class SlotMakerLogic extends SlotMakerUseCase
{

    public function handleExecution($request)
    {

        $response = array();
        $slotMaker  = SlotMaker::where('id',$request->get('id'))->where('isExecuted','!=',1)->first();

        if($slotMaker){
            echo json_encode($this->createDayOffSlots($slotMaker));
        }

    }

    private function createDayOffSlots($slotMaker)
    {
        $maxLoopDay = $slotMaker->totalDayLoop;
        $workinDay = $slotMaker->workingDays;
        $totalDaysInThisYear = (365 + Carbon::now()->format('L'));


        $slots = array();


        for ($i = 0; $i < $maxLoopDay; $i++) {

            $w = 1;
            for ($d = $totalDaysInThisYear; $d > 7; $d -= 6) {
                $week = $w++;
//                $slot[$i+1][$week] = Carbon::parse('first monday of January')->addWeek($week)->format('d-m-Y');
                $slots[$i + 1][$week] = Carbon::createFromFormat('d/m/Y',$slotMaker->firstDate)->addDays($i + ($workinDay+1) * $week)->format('d/m/Y');
            }

            // add first day off
            $slots[$i + 1]["0"] = Carbon::createFromFormat('d/m/Y',$slotMaker->firstDate)->addDays($i)->format('d/m/Y');
        }

        return $slots;
    }
}