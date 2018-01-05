<?php
namespace App\Attendance\Jobs;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:37 PM
 */
class RepeatGeneralSlot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalUtils;

    public $tries = 10;

    public function __construct()
    {

    }

    /**
     * repeat slot maker execution each year
     */
    public function handle()
    {
        $slotMaker = SlotMaker::find(1); //GENERAL SLOT MAKER
        $this->createDayOffSlots($slotMaker);
    }

    private function createDayOffSlots($slotMaker)
    {
        $maxLoopDay = $slotMaker->totalDayLoop;
        $workinDay = $slotMaker->workingDays;
        $totalDaysInThisYear = (365 + Carbon::now()->format('L'));

        for ($i = 0; $i < $maxLoopDay; $i++) {

            $dayOffs = array();

            $slot = Slots::find(1); // GENERAL SLOT

            $w = 1;
            for ($d = $totalDaysInThisYear; $d > 7; $d -= 6) {
                $week = $w++;
                $date = Carbon::parse('first sunday of January')->addDays($i + ($workinDay + 1) * $week)->format('d/m/Y');

                // Check if date is in current year
                if (Carbon::createFromFormat('d/m/Y', $date)->year == Carbon::now()->year) {
                    array_push($dayOffs, array('slotId' => $slot->id, 'date' => $date, 'description' => 'Weekly Day Off'));
                }
            }

            // add first day off
            $firstDayOff = Carbon::parse('first sunday of January')->addDays($i)->format('d/m/Y');

            // Check if date is in current year
            if (Carbon::createFromFormat('d/m/Y', $firstDayOff)->year == Carbon::now()->year) {
                array_push($dayOffs, array('slotId' => $slot->id, 'date' => $firstDayOff, 'description' => 'Weekly Day Off'));
            }

            // add missing working days
            if ($i + 1 > $workinDay) {
                for ($m = $i + 1; $m > 0; $m -= $workinDay + 1) {

                    $date = Carbon::parse('first sunday of January')->addDays($m - 1);

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

}