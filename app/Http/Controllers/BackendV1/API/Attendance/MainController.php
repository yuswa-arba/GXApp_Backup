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


    public function clock(Request $request, $punchType)
    {
        /* Validation Request*/
        $request->validate([
            'employeeId' => 'required',
            'cViaTypeId' => 'required'
//            'employeePhotoClockIn' => 'required'
        ]);

        $checkAvailability = $this->isAvailableToClock($request->employeeId, $punchType);

        if (!$checkAvailability['isFailed']
            && $checkAvailability['isAllowed'] == 1
            && $checkAvailability['shiftId'] != null) {

            $formRequest['employeeId'] = $request->employeeId;
            $formRequest['cDate'] = Carbon::now()->format('d/m/Y');
            $formRequest['cTime'] = Carbon::now()->format('H:i');
            $formRequest['cViaTypeId'] = $request->cViaTypeId;
            $formRequest['punchType'] = $punchType;
            $formRequest['shiftId'] = $checkAvailability['shiftId']; // get shift ID from $checkAvailability response

            if ($request->cViaTypeId == 1) {//by kiosk

                $request->validate(['cKioskId' => 'required']);

                $formRequest['cKioskId'] = $request->cKioskId;
            }

            if ($request->cViaTypeId == 2) {//by personal device

                $request->validate([
                    'cValidGeofence' => 'required',
                    'cLatitude' => 'required',
                    'cLongitude' => 'required'
                ]);

                $formRequest['cValidGeofence'] = $request->cValidGeofence;
                $formRequest['cLatitude'] = $request->cLatitude;
                $formRequest['cLongitude'] = $request->cLongitude;
            }

            if ($request->cViaTypeId == 3) {//by web portal
                $request->validate([
                    'cIpAddress' => 'required',
                    'cBrowser' => 'required'
                ]);

                $formRequest['cIpAddress'] = $request->cIpAddress;
                $formRequest['cBrowser'] = $request->cBrowser;
            }

            /* Run the logic */
            return AttendanceLogic::clocking($formRequest);

        } else {

            /* Return response */
            return $checkAvailability;
        }

    }

    private function isAvailableToClock($employeeId, $punchType)
    {
        return AttendanceLogic::checkAllowClocking($employeeId, $punchType);
    }

}
