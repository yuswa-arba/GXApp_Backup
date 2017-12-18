<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\Slots;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceLogic extends AttendanceUseCase
{

    public function handleKioskClockIn($request)
    {
        // TODO: Implement handleKioskClockIn() method.
    }

    public function handleKioskClockOut($request)
    {
        // TODO: Implement handleKioskClockOut() method.
    }

    public function handlePersonalDeviceClockIn($request)
    {
        // TODO: Implement handlePersonalDeviceClockIn() method.
    }

    public function handlePersonalDeviceClockOut($request)
    {
        // TODO: Implement handlePersonalDeviceClockOut() method.
    }

    public function handleWebPortalClockIn($request)
    {
        // TODO: Implement handleWebPortalClockIn() method.
    }

    public function handleWebPortalClockOut($request)
    {
        // TODO: Implement handleWebPortalClockOut() method.
    }

}