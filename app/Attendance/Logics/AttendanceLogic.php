<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;

class AttendanceLogic extends AttendanceUseCase
{

    public function handleKioskClockIn($formRequest)
    {
        /* Check if employee has clocked in once today */
        $existingTimeSheet = AttendanceTimesheet::where('employeeId', $formRequest['employeeId'])
            ->where('shiftId', $formRequest['shiftId'])
            ->whereNotNull('clockInDate')
            ->whereNotNull('clockInTime')
            ->first();

        if ($existingTimeSheet != null) {
            //TODO: Return response telling that employee has clocked in before
            return 'you have clocked in before at ' . $existingTimeSheet->clockInTime;
        } else {

            AttendanceTimesheet::updateOrCreate(
                [
                    'employeeId' => $formRequest['employeeId'],
                    'clockInDate' => $formRequest['cDate'],
                ],
                [
                    'shiftId' => $formRequest['shiftId'],
                    'clockInTime' => $formRequest['cTime'],
                    'clockInViaTypeId' => $formRequest['cViaTypeId'],
                    'clockInKioskId' => $formRequest['cKioskId']
                ]
            );
            //TODO: Trigger event to update dashboard
            //TODO: Return response + telling that employee has clocked in right in time/late/early , show clock out time
            return 'inserted';
        }

    }

    public function handleKioskClockOut($formRequest)
    {
        echo 'handle kiosk clock out';
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
     * return result
     * */
    public function handleClockingAvailability($employeeId, $punchType)
    {
        $result = array();
        $employee = MasterEmployee::find($employeeId);

        if ($employee != null) {

            $shiftId = 1;//default shiftId

            $employeeSlotSchedule = EmployeeSlotSchedule::where('employeeId', $employeeId)->first();

            if ($employeeSlotSchedule != null) {
                $slot = $employeeSlotSchedule->slot;

                /* Get shift ID if exist*/
                $slotShiftSchedule = SlotShiftSchedule::where('slotId', $slot->id)->where('date', Carbon::now()->format('d/m/Y'))->first(['shiftId']);

                /* Set shift id if slot is assigned to specific shif*/
                if ($slotShiftSchedule != null) {
                    $shiftId = $slotShiftSchedule->shiftId;
                }

                /* If slot is not using Mapping set to default shift */
                if (!$slot->isUsingMapping) {
                    $shiftId = 1; // use default shift ID
                }

            }

            $attdSchedule = AttendanceSchedule::where('shiftId', $shiftId)->first(); // get default shift attendance schedule (8 to 17)

            /* return result based on punch type */
            if ($punchType == 'in') {

                $result['isFailed'] = false;
                $result['isAllowed'] = $attdSchedule->allowedToCheckIn;
                $result['shiftId'] = $shiftId;

                if ($attdSchedule->allowedToCheckIn == 1) {
                    $result['message'] = 'Allowed to Clock-In';
                } else {
                    $timeAvailable = Carbon::createFromFormat('H:i', Shifts::find($shiftId)->workStartAt)->subHours(1)->format('H:i');
                    $result['message'] = 'Not allowed to Clock-In yet until ' . $timeAvailable;
                }

            } elseif ($punchType == 'out') {

                $result['isFailed'] = false;
                $result['isAllowed'] = $attdSchedule->allowedToCheckOut;
                $result['shiftId'] = $shiftId;

                if ($attdSchedule->allowedToCheckOut == 1) {
                    $result['message'] = 'Allowed to Clock-Out';
                } else {
                    $timeAvailable = Carbon::createFromFormat('H:i', Shifts::find($shiftId)->workEndAt)->format('H:i');
                    $result['message'] = 'Not allowed to Clock-Out yet until ' . $timeAvailable;
                }

            } else {
                // return error response
                $result['isFailed'] = true;
                $result['message'] = 'Undefined punch type';
            }

        } else {
            // return error response employee not found
            $result['isFailed'] = true;
            $result['message'] = 'Unable to find employee data';
        }

        return $result;
    }
}