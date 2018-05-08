<?php

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotMakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $firstSundayOfTheYear =new Carbon('first sunday of January '.Carbon::now()->year);

        $data = array(
            [
                'id'=>'1',
                'name'=>'General',
                'firstDate'=>$firstSundayOfTheYear->format('d/m/Y'),
                'relatedToJobPosition'=>'0',
                'jobPositionId'=>'',
                'totalDayLoop'=>'1',
                'workingDays'=>'6',
                'allowMultipleAssign'=>'1',
                'isExecuted'=>'0',
                'executedAt'=>'',
                'executedBy'=>'',
            ]
        );


        if(DB::table('slotMaker')->where('id',1)->first()){
            DB::table('slotMaker')->where('id',1)->update($data);
        } else {
            DB::table('slotMaker')->insert($data);
        }

        $slotMaker = \App\Attendance\Models\SlotMaker::find(1);
        $execute = $this->createDayOffSlots($slotMaker)->updateSlotMaker($slotMaker);

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
            if ($i + 1 > $workinDay) {
                for ($m = $i + 1; $m > 0; $m -= $workinDay + 1) {

                    $date = Carbon::createFromFormat('d/m/Y', $slotMaker->firstDate)->addDays($m - 1);

                    if ($date->day != $i + 1) {
                        if (Carbon::createFromFormat('d/m/Y', $date->format('d/m/Y'))->year == Carbon::now()->year) {
                            array_push($dayOffs, array('slotId' => $slot->id, 'date' => $date->format('d/m/Y'), 'description' => 'Weekly Day Off'));
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
        return SlotMaker::where('id', $slotMaker->id)->update(['isExecuted' => 1, 'executedAt' => Carbon::now(), 'executedBy' => 'seeder']);
    }



}
