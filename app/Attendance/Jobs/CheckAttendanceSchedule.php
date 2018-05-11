<?php
namespace App\Attendance\Jobs;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\Shifts;
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
class CheckAttendanceSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;

    public function __construct()
    {

    }

    /**
     * check attendance schedule
     */
    public function handle()
    {

        $nowTime = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y H:i'));
        $shifts = Shifts::all();

        foreach ($shifts as $shift) {

            $workStartAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y'). ' '. $shift->workStartAt);
            $workEndAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y'). ' '. $shift->workEndAt);

//            if($shift->isOvernight==1){
//                $workEndAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->addDay()->format('d/m/Y'). ' '. $shift->workEndAt);
//            }

            $breakStartAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y'). ' '. $shift->breakStartAt);
            $breakEndAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y'). ' '. $shift->breakEndAt);


            // allow check in before 1 hour
            if ($nowTime->gte($workStartAt->subHour(1))) {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToCheckIn' => 1,'allowedToCheckOut' => 0]);
            } else {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToCheckIn' => 0]);
            }

            // allow check out after specified time
            if ($nowTime->gte($workEndAt)) {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToCheckIn' => 0,'allowedToCheckOut' => 1]);
            } else {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToCheckOut' => 0]);
            }

            // allow break in after specified time or 2 hours after
            if ($nowTime->gte($breakStartAt) && $nowTime->lte($breakStartAt->addHours(2))) {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToBreakIn' => 1]);
            } else {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToBreakIn' => 0]);
            }

            // allow break out before specified time
            if ($nowTime->lte($breakEndAt)) {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToBreakOut' => 1]);
            } else {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToBreakOut' => 0]);
            }

        }

    }

}