<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Account\Traits\TokenUtils;
use App\Attendance\Logics\AttendanceLogic;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Config;

class MainController extends Controller
{
    use TokenUtils;
    use GlobalUtils;

    public function clock(Request $request, $punchType)
    {

        /* Validation Request*/

        $validator = Validator::make($request->all(), [
            'employeeId' => 'required',
            'cViaTypeId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Employee ID and Via type required';
            return response()->json($response, 200);
        }

        $checkAvailability = $this->isAvailableToClock($request->employeeId, $punchType);

        if (!$checkAvailability['isFailed']
            && $checkAvailability['isAllowed'] == 1
            && $checkAvailability['shiftId'] != null
        ) {

            $formRequest['employeeId'] = $request->employeeId;
            $formRequest['cDate'] = Carbon::now()->format('d/m/Y');
            $formRequest['cTime'] = Carbon::now()->format('H:i');
            $formRequest['cViaTypeId'] = $request->cViaTypeId;
            $formRequest['punchType'] = $punchType;
            $formRequest['shiftId'] = $checkAvailability['shiftId']; // get shift ID from $checkAvailability response

            if ($request->cViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK']) {//by kiosk

                if ($punchType == 'in') {
                    $validator = Validator::make($request->all(), [
                        'clockInKioskId' => 'required',
                    ]);

                    if ($validator->fails()) {
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                        $response['message'] = 'Kiosk ID Required';
                        return response()->json($response, 200);
                    }

                    /* Set clock in kiosk ID*/
                    $formRequest['cKioskId'] = $request->clockInKioskId;
                }

                if ($punchType == 'out') {
                    $validator = Validator::make($request->all(), [
                        'clockOutKioskId' => 'required',
                    ]);

                    if ($validator->fails()) {
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                        $response['message'] = 'Kiosk ID Required';
                        return response()->json($response, 200);
                    }

                    /* Set clock out kiosk ID*/
                    $formRequest['cKioskId'] = $request->clockOutKioskId;
                }

                /* Set if its approved by microsoft */
                $formRequest['attendanceApproveId'] = 0;
                if ($request->isMicrosoftFaceAPIApproved == "yes") {
                    $formRequest['attendanceApproveId'] = 2; //MICROSOFT FACE API APPROVAL
                }

                /*Handle photo uploads if exist*/
                $formRequest['employeePhotoClockIn'] = $this->saveClockInPhoto($request);
                $formRequest['employeePhotoClockOut'] = $this->saveClockOutPhoto($request);

            }

            if ($request->cViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_PERSONAL_DEVICE']) {//by personal device
                $validator = Validator::make($request->all(), [
                    'cValidGeofence' => 'required',
                    'cLatitude' => 'required',
                    'cLongitude' => 'required'
                ]);

                if ($validator->fails()) {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                    $response['message'] = 'Valid user location required';
                    return response()->json($response, 200);
                }

                $formRequest['cValidGeofence'] = $request->cValidGeofence;
                $formRequest['cLatitude'] = $request->cLatitude;
                $formRequest['cLongitude'] = $request->cLongitude;
            }

            if ($request->cViaTypeId == ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_WEB_PORTAL']) {//by web portal

                $validator = Validator::make($request->all(), [
                    'cIpAddress' => 'required',
                    'cBrowser' => 'required'
                ]);

                if ($validator->fails()) {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                    $response['message'] = 'User IP Address and Browser required';
                    return response()->json($response, 200);
                }

                $formRequest['cIpAddress'] = $request->cIpAddress;
                $formRequest['cBrowser'] = $request->cBrowser;
            }

            /* Run the logic */
            return AttendanceLogic::clocking($formRequest);

        } else {
            /* Return response */
            return response()->json($checkAvailability, 200);
        }

    }

    private function isAvailableToClock($employeeId, $punchType)
    {
        return AttendanceLogic::checkAllowClocking($employeeId, $punchType);
    }

    private function saveClockInPhoto(Request $request)
    {
        /* Save Clock In Photo if exist */
        if ($request->hasFile('employeePhotoClockIn') && $request->file('employeePhotoClockIn')->isValid()) {

            $employeeNo = MasterEmployee::find($request->employeeId)['employeeNo'];
            $filename = $employeeNo . Carbon::now()->format('dmYHis') . '.png';

            $request->employeePhotoClockIn->move(base_path(Configs::$IMAGE_PATH['ATTENDANCE_PHOTO']), $filename);

            return $filename; // insert to form request
        } else {
            return "";
        }

    }

    private function saveClockOutPhoto(Request $request)
    {

        /* Save Clock Out Photo if exist */
        if ($request->hasFile('employeePhotoClockOut') && $request->file('employeePhotoClockOut')->isValid()) {

            $employeeNo = MasterEmployee::find($request->employeeId)['employeeNo'];
            $filename = $employeeNo . Carbon::now()->format('dmYHis') . '.png';

            $request->employeePhotoClockOut->move(base_path(Configs::$IMAGE_PATH['ATTENDANCE_PHOTO']), $filename);

            return $filename; // insert to form request
        } else {
            return "";
        }

    }
}
