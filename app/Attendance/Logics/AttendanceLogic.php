<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

class AttendanceLogic extends AttendanceUseCase
{

    public function handleKioskClockIn($formRequest)
    {
        echo 'handle kiosk clock in';
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

}