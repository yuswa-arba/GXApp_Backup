<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics;


use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;

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
     * return response array
     * */
    public static function clocking($formRequest)
    {
        $punchType = $formRequest['punchType'];

        $byKIosk = $formRequest['cViaTypeId'] == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK'];
        $byPersonalDevice = $formRequest['cViaTypeId'] == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_PERSONAL_DEVICE'];
        $byWebPortal = $formRequest['cViaTypeId'] == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_WEB_PORTAL'];


        if ($byKIosk) {
            if ($punchType == 'in') {
                return (new static)->handleKioskClockIn($formRequest);
            } elseif ($punchType == 'out') {
                return (new static)->handleKioskClockOut($formRequest);
            }
        }

        if ($byPersonalDevice) {
            if ($punchType == 'in') {
                return (new static)->handlePersonalDeviceClockIn($formRequest);
            } elseif ($punchType == 'out') {
                return (new static)->handlePersonalDeviceClockOut($formRequest);
            }
        }

        if ($byWebPortal) {
            if ($punchType == 'in') {
                return (new static)->handleWebPortalClockIn($formRequest);
            } elseif ($punchType == 'out') {
                return (new static)->handleWebPortalClockOut($formRequest);
            }
        }

        //else
        return response()->json('Invalid Request', 400);

    }

    /*
     * @param employeeId uuid
     * return boolean
     * */
    public static function checkAllowClocking($employeeId,$punchType){

        return (new static)->handleClockingAvailability($employeeId,$punchType);

    }


    abstract public function handleKioskClockIn($formRequest);

    abstract public function handleKioskClockOut($formRequest);

    abstract public function handlePersonalDeviceClockIn($formRequest);

    abstract public function handlePersonalDeviceClockOut($formRequest);

    abstract public function handleWebPortalClockIn($formRequest);

    abstract public function handleWebPortalClockOut($formRequest);

    abstract public function handleClockingAvailability($employeeId,$punchType);


}