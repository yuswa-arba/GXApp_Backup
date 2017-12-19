<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Account\Traits\TokenUtils;
use App\Attendance\Logics\AttendanceLogic;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    use TokenUtils;

    
    public function clockIn(Request $request)
    {
        $request->validate([
//            'employeeId'=>'required',
            'clockInViaTypeId' => 'required',
//            'employeePhotoClockIn' => 'required'
        ]);

        $formRequest['employeeId'] = $this->getUserByAccessToken()->employeeId;
        $formRequest['clockInDate'] = Carbon::now()->format('d/m/Y');
        $formRequest['clockInTime'] = Carbon::now()->format('H:i');
        $formRequest['viaTypeId'] = $request->clockInViaTypeId;
        $formRequest['isClockingIn'] = true;


        if ($request->clockInViaTypeId == 1) {//by kiosk

            $request->validate(['clockInKioskId' => 'required']);
            $formRequest['clockInKioskId'] = $request->clockInKioskId;
        }

        if ($request->clockInViaTypeId == 2) {//by personal device

            $request->validate([
                'clockInValidGeofence' => 'required',
                'clockInLatitude' => 'required',
                'clockInLongitude' => 'required'
            ]);
            $formRequest['clockInValidGeofence'] = $request->clockInValidGeofence;
            $formRequest['clockInLatitude'] = $request->clockInLatitude;
            $formRequest['clockInLongitude'] = $request->clockInLongitude;

        }

        if ($request->clockInViaTypeId == 3) {//by web portal
            $request->validate([
                'clockInIpAddress' => 'required',
                'clockInBrowser' => 'required'
            ]);
            $formRequest['clockInIpAddress'] = $request->clockInIpAddress;
            $formRequest['clockInBrowser'] = $request->clockInBrowser;
        }

        return $this->getOAuthAccessToken();
//        return AttendanceLogic::clock($formRequest);
    }

    public function clockOut(Request $request)
    {

        $request->validate([
            'clockOutViaTypeId' => 'required',
//            'employeePhotoClockIn' => 'required'
        ]);

        $formRequest['employeeId'] = $this->getUserByAccessToken()->employeeId;
        $formRequest['clockOutDate'] = Carbon::now()->format('d/m/Y');
        $formRequest['clockOutTime'] = Carbon::now()->format('H:i');
        $formRequest['viaTypeId'] = $request->clockOutViaTypeId;
        $formRequest['isClockingIn'] = false;


        if ($request->clockOutViaTypeId == 1) {//by kiosk
            $request->validate(['clockOutKioskId' => 'required']);
            $formRequest['clockOutKioskId'] = $request->clockOutKioskId;
        }

        if ($request->clockOutViaTypeId == 2) {//by personal device

            $request->validate([
                'clockOutValidGeofence' => 'required',
                'clockOutLatitude' => 'required',
                'clockOutLongitude' => 'required'
            ]);
            $formRequest['clockOutValidGeofence'] = $request->clockOutValidGeofence;
            $formRequest['clockOutLatitude'] = $request->clockOutLatitude;
            $formRequest['clockOutLongitude'] = $request->clockOutLongitude;

        }

        if ($request->clockOutViaTypeId == 3) {//by web portal
            $request->validate([
                'clockOutIpAddress' => 'required',
                'clockOutBrowser' => 'required'
            ]);
            $formRequest['clockOutIpAddress'] = $request->clockOutIpAddress;
            $formRequest['clockOutBrowser'] = $request->clockOutBrowser;
        }

        return AttendanceLogic::clock($formRequest);
    }
}
