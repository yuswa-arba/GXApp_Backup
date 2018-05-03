<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */
namespace App\Attendance\Traits;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Shifts;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use Carbon\Carbon;


trait AttendanceCheckerUtil
{
    public function checkValidation(AttendanceTimesheet $timesheet)
    {
        $cInTime = '';
        $cOutTime = '';
        $cInViaTypeId = $timesheet->clockInViaTypeId;
        $cOutViaTypeId = $timesheet->clockOutViaTypeId;
        $shift = Shifts::find($timesheet->shiftId);
        $shiftWorkStartAt = Carbon::createFromFormat('H:i', $shift->workStartAt);
        $shiftWorkEndAt = Carbon::createFromFormat('H:i', $shift->workEndAt);
        $currTime = Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));

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
            /* If its not MANUALLY INPUT CHECK IT */
            if ($timesheet->attendanceValidationId != 98) {

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
                        if ($cInViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK'] || $cOutViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK']) {
                            $timesheet->attendanceValidationId = 10; // No Photo
                            $isValid = 0;
                        }
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

                    if ($cInViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_FINGERSPOT']) {
                        // TODO: Validation by this type
                    }
                    if ($cOutViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_FINGERSPOT']) {
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
    }

    public function checkValidationNow(AttendanceTimesheet $timesheet)
    {
        $cInTime = '';
        $cOutTime = '';
        $cInViaTypeId = $timesheet->clockInViaTypeId;
        $cOutViaTypeId = $timesheet->clockOutViaTypeId;
        $shift = Shifts::find($timesheet->shiftId);
        $shiftWorkStartAt = Carbon::createFromFormat('H:i', $shift->workStartAt);
        $shiftWorkEndAt = Carbon::createFromFormat('H:i', $shift->workEndAt);
        $currTime = Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));

        /* Clock In Time in Carbon*/
        if ($timesheet->clockInTime != null) {
            $cInTime = Carbon::createFromFormat('H:i', $timesheet->clockInTime);
        }
        /* Clock Out Time in Carbon*/
        if ($timesheet->clockOutTime != null) {
            $cOutTime = Carbon::createFromFormat('H:i', $timesheet->clockOutTime);
        }


        /* If its not MANUALLY INPUT CHECK IT */
        if ($timesheet->attendanceValidationId != 98) {

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
                    if ($cInViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK'] || $cOutViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK']) {
                        $timesheet->attendanceValidationId = 10; // No Photo
                        $isValid = 0;
                    }
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

                if ($cInViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_FINGERSPOT']) {
                    // TODO: Validation by this type
                }
                if ($cOutViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_FINGERSPOT']) {
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

    public function checkApproval(AttendanceTimesheet $timesheet)
    {

        $shift = Shifts::find($timesheet->shiftId);
        $shiftWorkEndAt = Carbon::createFromFormat('H:i', $shift->workEndAt);
        $currTime = Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));

        /* If work time has ended */
        if ($currTime->gt($shiftWorkEndAt)) {
            if ($timesheet->attendanceApproveId != 1 && // Microsoft Face API
                $timesheet->attendanceApproveId != 2 && // Manager Approved
                $timesheet->attendanceApproveId != 3 && // Edited by Manager
                $timesheet->attendanceApproveId != 4 && // Fingerspot
                $timesheet->attendanceApproveId != 98   // Disapproved
            ) {
                $timesheet->attendanceApproveId = 99; // Need Approval
                $timesheet->approvedBy = ''; // Need Approval

            }
        }

        $timesheet->save();
    }
}