<?php
namespace App\Attendance\Jobs;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Shifts;
use App\Attendance\Traits\AttendanceCheckerUtil;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
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
class CheckAttendanceTimesheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use AttendanceCheckerUtil;

    public $tries = 10;

    public function __construct()
    {

    }

    /**
     * check attendance timesheet
     */
    public function handle()
    {

        $curDate = Carbon::now()->format('d/m/Y');
        $timesheets = AttendanceTimesheet::where('clockInDate', $curDate)->orWhere('clockOutDate', $curDate)->get();

        foreach ($timesheets as $timesheet) {
            $this->checkValidation($timesheet);
            $this->checkApproval($timesheet);
        }


    }

}