<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics;


use Illuminate\Http\Request;

abstract class AttendanceUseCase
{

    public static function clock(Request $request)
    {
        $byKIosk = false;
        $byPersonalDevice = false;
        $byWebPortal = false;

        $clockIn = false;

        if ($byKIosk) {
            if ($clockIn) {
                return (new static)->handleKioskClockIn($request);
            } else {
                return (new static)->handleKioskClockOut($request);
            }
        }

        if ($byPersonalDevice) {
            if ($clockIn) {
                return (new static)->handlePersonalDeviceClockIn($request);
            } else {
                return (new static)->handlePersonalDeviceClockOut($request);
            }
        }

        if ($byWebPortal) {
            if ($clockIn) {
                return (new static)->handleWebPortalClockIn($request);
            } else {
                return (new static)->handleWebPortalClockOut($request);
            }
        }

        //else
        return response()->json('Invalid Request',500);

    }


    abstract public function handleKioskClockIn($request);

    abstract public function handleKioskClockOut($request);

    abstract public function handlePersonalDeviceClockIn($request);

    abstract public function handlePersonalDeviceClockOut($request);

    abstract public function handleWebPortalClockIn($request);

    abstract public function handleWebPortalClockOut($request);

}