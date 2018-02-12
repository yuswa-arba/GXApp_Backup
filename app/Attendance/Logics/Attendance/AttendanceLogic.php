<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Attendance;

use App\Attendance\Events\EmployeeClocked;
use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\AttendanceSetting;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use Carbon\Carbon;

class AttendanceLogic extends AttendanceUseCase
{

    public function handleKioskClockIn($formRequest)
    {
        /* Check if employee has clocked in once today */
        $existingTimeSheet = AttendanceTimesheet::where('employeeId', $formRequest['employeeId'])
            ->where('shiftId', $formRequest['shiftId'])
            ->where('clockInDate', Carbon::now()->format('d/m/Y'))
            ->whereNotNull('clockInTime')
            ->first();

        if ($existingTimeSheet != null) {
            /* Return response employee has clocked in before */
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['ALREADY_CLOCKED_IN'];
            $response['message'] = 'You have clocked in before at ' . $existingTimeSheet->clockInTime;
            return response()->json($response, 200);

        } else {

            $insert = AttendanceTimesheet::updateOrCreate(
                [
                    'employeeId' => $formRequest['employeeId'],
                    'clockInDate' => $formRequest['cDate'],
                ],
                [
                    'shiftId' => $formRequest['shiftId'],
                    'clockInTime' => $formRequest['cTime'],
                    'clockInViaTypeId' => $formRequest['cViaTypeId'],
                    'clockInKioskId' => $formRequest['cKioskId'],
                    'employeePhotoClockIn' => $formRequest['employeePhotoClockIn'],
                    'attendanceApproveId' => $formRequest['attendanceApproveId']
                ]
            );

            $response = array();
            if ($insert) {

                /* Broacast event to update Dashboard feed */
                broadcast(new EmployeeClocked($insert->id, 'in'));

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                $response['message'] = 'Unknown server error';
            }

            return response()->json($response, 200);
        }

    }

    public function handleKioskClockOut($formRequest)
    {
        /* Check if employee has clocked in once today */
        $existingTimeSheet = AttendanceTimesheet::where('employeeId', $formRequest['employeeId'])
            ->where('shiftId', $formRequest['shiftId'])
            ->where('clockOutDate', Carbon::now()->format('d/m/Y'))
            ->whereNotNull('clockOutTime')
            ->first();

        if ($existingTimeSheet != null) {
            /* Return response employee has clocked out before */
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['ALREADY_CLOCKED_OUT'];
            $response['message'] = 'You have clocked out before at ' . $existingTimeSheet->clockOutTime;
            return response()->json($response, 200);

        } else {

            /* Save to where the employee clocked in else create a new one */
            $insert = AttendanceTimesheet::updateOrCreate(
                [
                    'employeeId' => $formRequest['employeeId'],
                    'clockInDate' => $formRequest['cDate'],
                ],
                [
                    'clockOutDate' => $formRequest['cDate'],
                    'shiftId' => $formRequest['shiftId'],
                    'clockOutTime' => $formRequest['cTime'],
                    'clockOutViaTypeId' => $formRequest['cViaTypeId'],
                    'clockOutKioskId' => $formRequest['cKioskId'],
                    'employeePhotoClockOut' => $formRequest['employeePhotoClockOut'],
                    'attendanceApproveId' => $formRequest['attendanceApproveId']
                ]
            );

            $response = array();
            if ($insert) {

                /* Broacast event to update Dashboard feed */
                broadcast(new EmployeeClocked($insert->id, 'out'));

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                $response['message'] = 'Unknown server error';
            }


            return response()->json($response, 200);
        }

    }

    public function handlePersonalDeviceClockIn($formRequest)
    {
        echo 'handle personal device clock in';
    }

    public function handlePersonalDeviceClockOut($formRequest)
    {
        echo 'handle personal device clock out';
    }

    public function handleWebPortalClockIn($formRequest)
    {
        echo 'handle web portal clock in';
    }

    public function handleWebPortalClockOut($formRequest)
    {
        echo 'handle web portal clock out';
    }


    /*
     * @description checking if allow to clocking
     * return clocking availability  shift ID
     * */
    public function handleClockingAvailability($employeeId, $punchType)
    {
        $response = array();
        $employee = MasterEmployee::find($employeeId);

        if ($employee != null) {

            $shiftId = 1;//default shiftId
            $slotId = 1;//default slotId

            $employeeSlotSchedule = EmployeeSlotSchedule::where('employeeId', $employeeId)->first();

            if ($employeeSlotSchedule != null) {

                $slot = $employeeSlotSchedule->slot;
                $slotId = $slot->id;

                /* Get shift ID if exist*/
                $slotShiftSchedule = SlotShiftSchedule::where('slotId', $slot->id)->where('date', Carbon::now()->format('d/m/Y'))->first(['shiftId']);

                /* Set shift id if slot is assigned to specific shif*/
                if ($slotShiftSchedule != null) {
                    $shiftId = $slotShiftSchedule->shiftId;
                }

                /* If slot is not using Mapping or is Deleted set to default shift */
                if (!$slot->isUsingMapping || $slot->isDeleted) {
                    $shiftId = 1; // use default shift ID
                }

            }

            /* Check public holidays and day off for this slot */
            $dayOffSchedule = DayOffSchedule::where('slotId', $slotId)->where('date', Carbon::now()->format('d/m/Y'))->first();

            if ($dayOffSchedule != null) {
                // return error response
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['IS_DAY_OFF'];
                $response['message'] = 'Error clocking. Day off: ' . $dayOffSchedule->description;
                $response['isAllowed'] = false;
                return $response;
            }


            /* Check Attendance schedule first */
            $this->checkAttendanceSchedule($shiftId);

            $attdSchedule = AttendanceSchedule::where('shiftId', $shiftId)->first(); // get default shift attendance schedule (8 to 17)

            /* return result based on punch type */
            if ($punchType == 'in') {

                if ($attdSchedule->allowedToCheckIn == 1) {

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Allowed to Clock-In';
                    $response['isAllowed'] = $attdSchedule->allowedToCheckIn;
                    $response['shiftId'] = $shiftId;
                    return $response;


                } else {
                    $timeAvailable = Carbon::createFromFormat('H:i', Shifts::find($shiftId)->workStartAt)->subHours(1)->format('H:i');

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['NOT_ALLOWED_TO_CLOCK_IN'];
                    $response['message'] = 'Not allowed to Clock-In yet until ' . $timeAvailable;
                    $response['isAllowed'] = $attdSchedule->allowedToCheckIn;
                    $response['shiftId'] = $shiftId;
                    return $response;

                }

            } elseif ($punchType == 'out') {

                // Check if attendance setting allow clock out early

                $allowEarlyClockOut = AttendanceSetting::where('name','allow-early-clock-out')->first()->value;

                if($allowEarlyClockOut==1){ //yes its allowed

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Allowed to Clock-Out';
                    $response['isAllowed'] = 1;
                    $response['shiftId'] = $shiftId;
                    return $response;

                } else{ // not allowed, check attendance schedule

                    if ($attdSchedule->allowedToCheckOut == 1) {

                        $response['isFailed'] = false;
                        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                        $response['message'] = 'Allowed to Clock-Out';
                        $response['isAllowed'] = $attdSchedule->allowedToCheckOut;
                        $response['shiftId'] = $shiftId;
                        return $response;

                    } else {
                        $timeAvailable = Carbon::createFromFormat('H:i', Shifts::find($shiftId)->workEndAt)->format('H:i');
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ATTD_ERR_CODES['NOT_ALLOWED_TO_CLOCK_OUT'];
                        $response['message'] = 'Not allowed to Clock-Out yet until ' . $timeAvailable;
                        $response['isAllowed'] = $attdSchedule->allowedToCheckOut;
                        $response['shiftId'] = $shiftId;
                        return $response;

                    }
                }

            } else {
                // return error response
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNDEFINED_PUNCH_TYPE'];
                $response['message'] = 'Undefined punch type';
                return $response;

            }

        } else {
            // return error response employee not found
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
            $response['message'] = 'Unable to find employee data';
            return $response;

        }

    }


    private function checkAttendanceSchedule($shiftId)
    {

        $nowTime = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y H:i'));
        $shift = Shifts::find($shiftId);

        if ($shift) {

            $workStartAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y') . ' ' . $shift->workStartAt);
            $workEndAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y') . ' ' . $shift->workEndAt);

//            if($shift->isOvernight==1){
//                $workEndAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->addDay()->format('d/m/Y'). ' '. $shift->workEndAt);
//            }

            $breakStartAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y') . ' ' . $shift->breakStartAt);
            $breakEndAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y') . ' ' . $shift->breakEndAt);


            // allow check in before 1 hour
            if ($nowTime->gte($workStartAt->subHour(1))) {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToCheckIn' => 1, 'allowedToCheckOut' => 0]);
            } else {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToCheckIn' => 0]);
            }

            // allow check out after specified time
            if ($nowTime->gte($workEndAt)) {
                AttendanceSchedule::updateOrCreate(['shiftId' => $shift->id], ['allowedToCheckIn' => 0, 'allowedToCheckOut' => 1]);
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