<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Account\Traits\TokenUtils;
use App\Attendance\Logics\AttendanceLogic;
use App\Attendance\Logics\Kiosk\KioskAuthLogic;
use App\Attendance\Models\KioskActivity;
use App\Attendance\Models\Kiosks;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class KioskAuthController extends Controller
{

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kioskId' => 'required',
            'passcode' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameter';
            return response()->json($response, 200);
        }


        return KioskAuthLogic::login($request);
    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kioskId' => 'required',
            'passcode' => 'required',
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        return KioskAuthLogic::logout($request);
    }

    public function activateKiosk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kioskId' => 'required',
            'activationCode' => 'required',
            'passcode' => 'required',
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        return KioskAuthLogic::activate($request);
    }

    public function test()
    {
        $response = array();
        $response['testResult'] = true;
        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
        $response['message'] = Carbon::now()->timestamp;

        return response()->json($response, 200);
    }
}
