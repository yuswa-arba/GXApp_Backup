<?php
namespace App\Attendance\Jobs;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Shifts;
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

    private function checkValidation($timesheet)
    {
        $cInTime = '';
        $cOutTime = '';
        $cInViaTypeId = $timesheet->clockInViaTypeId;
        $cOutViaTypeId = $timesheet->clockOutViaTypeId;
        $shift = Shifts::find($timesheet->shiftId);
        $shiftWorkStartAt = Carbon::createFromFormat('H:i', $shift->workStartAt);
        $shiftWorkEndAt = Carbon::createFromFormat('H:i', $shift->workEndAt);
        $currTime =Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));

        /* Clock In Time in Carbon*/
        if ($timesheet->clockInTime != null) {
            $cInTime = Carbon::createFromFormat('H:i', $timesheet->clockInTime);
        }
        /* Clock Out Time in Carbon*/
        if ($timesheet->clockOutTime != null) {
            $cOutTime = Carbon::createFromFormat('H:i', $timesheet->clockOutTime);
        }
        /* Current Time in Carbon*/

        /* If work time has ended */
        if ($currTime->gt($shiftWorkEndAt)) {

            $timesheet->attendanceValidationId = 99; // Default set to 'Invalid'

            $isValid = 1;

            if ($cInTime != '' || $cOutTime != '') {
                /* Validate Clock In Clock Out time based on shift */
                if ($cInTime == '' && $cOutTime != '') {
                    $timesheet->attendanceValidationId = 2; // No Clock In
                    $isValid = 0;
                } else {
                    if ($cInTime->gt($shiftWorkStartAt)) {
                        $timesheet->attendanceValidationId = 4; // Late clock In
                        $isValid = 0;
                    }
                }

                if ($cOutTime == '' && $cInTime != '') {
                    $timesheet->attendanceValidationId = 3; // No Clock Out
                    $isValid = 0;
                } else {
                    if ($cOutTime->lt($shiftWorkEndAt)) {
                        $timesheet->attendanceValidationId = 5; // Early clock out
                        $isValid = 0;
                    }
                }

                if ($timesheet->employeePhotoClockIn != null || $timesheet->employeePhotoClockOut != null) {
                    if ($cInViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK']) {

                        if ($timesheet->employeePhotoClockIn == null) {
                            $timesheet->attendanceValidationId = 8; // No Clock In Photo
                            $isValid = 0;
                        }
                    }

                    if ($cOutViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK']) {
                        if ($timesheet->employeePhotoClockOut == null) {
                            $timesheet->attendanceValidationId = 9; // No Clock Out Photo
                            $isValid = 0;
                        }
                    }
                } else {
                    $timesheet->attendanceValidationId = 10; // No Photo
                    $isValid = 0;
                }


                if ($cInViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_PERSONAL_DEVICE']) {
                    // TODO: Validation by this type
                }

                if ($cOutViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_PERSONAL_DEVICE']) {
                    // TODO: Validation by this type
                }

                if ($cInViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_WEB_PORTAL']) {
                    // TODO: Validation by this type
                }
                if ($cOutViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_WEB_PORTAL']) {
                    // TODO: Validation by this type
                }
            } else {
                $timesheet->attendanceValidationId = 12; // Clocking Not Completed
                $isValid = 0;
            }

            /* If only all the validation is true then set to valid */
            if ($isValid == 1) {
                $timesheet->attendanceValidationId = 1;
            }

            $timesheet->save();

        }
    }

    private function checkApproval($timesheet)
    {

        $shift = Shifts::find($timesheet->shiftId);
        $shiftWorkEndAt = Carbon::createFromFormat('H:i',$shift->workEndAt);
        $currTime =Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));

        /* If work time has ended */
        if ($currTime->gt($shiftWorkEndAt)) {
            if ($timesheet->attendanceApproveId != 1 && // Microsoft Face API
                $timesheet->attendanceApproveId != 2 && // Manager
                $timesheet->attendanceApproveId != 3    // Disapproved
            ) {
                $timesheet->attendanceApproveId = 99 ; // Need Approval
            }
        }

        $timesheet->save();
    }

}