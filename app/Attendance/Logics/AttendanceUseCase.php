<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics;


abstract class AttendanceUseCase
{

    /*
     * @param employeeId uuid
     * @param viaTypeId int
     * @param iClockingIn boolean
     * @param clockInDate/clockOutDate
     * @param clockInTime/clockOutTime
     * @param employeePhotoClockIn/employeePhotoClockOut
     * @param clockInValidGeofence/clockOutValidGeofence (by android)
     * @param clockInLatitude/clockInLongitude/clockOutLatitude/clockOutLongitude (by android)
     * @param clockInKioskId/clockOutKioskId (by kiosk)
     * @param clockInKioskId/clockOutKioskId (by web portal)
     * @param clockInBrowser/clockOutBrowser (by web portal)
     *
     * */
    public static function clock($formRequest)
    {
    
        $byKIosk = $formRequest['viaTypeId'] == 1;
        $byPersonalDevice = $formRequest['viaTypeId'] == 2;
        $byWebPortal = $formRequest['viaTypeId'] == 3;
        $clockIn = $formRequest['isClockingIn'];

        if ($byKIosk) {
            if ($clockIn) {
                return (new static)->handleKioskClockIn($formRequest);
            } else {
                return (new static)->handleKioskClockOut($formRequest);
            }
        }

        if ($byPersonalDevice) {
            if ($clockIn) {
                return (new static)->handlePersonalDeviceClockIn($formRequest);
            } else {
                return (new static)->handlePersonalDeviceClockOut($formRequest);
            }
        }

        if ($byWebPortal) {
            if ($clockIn) {
                return (new static)->handleWebPortalClockIn($formRequest);
            } else {
                return (new static)->handleWebPortalClockOut($formRequest);
            }
        }

        //else
        return response()->json('Invalid Request', 500);

    }


    abstract public function handleKioskClockIn($formRequest);

    abstract public function handleKioskClockOut($formRequest);

    abstract public function handlePersonalDeviceClockIn($formRequest);

    abstract public function handlePersonalDeviceClockOut($formRequest);

    abstract public function handleWebPortalClockIn($formRequest);

    abstract public function handleWebPortalClockOut($formRequest);

}