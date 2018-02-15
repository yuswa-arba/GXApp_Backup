<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Attendance\Models\Kiosks;
use App\Attendance\Transformers\KioskTransformer;
use App\Employee\Models\FacePerson;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeLastActivityTransfomer;
use App\Employee\Transformers\EmployeeNameAndIdTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;


class KioskController extends Controller
{

    public function detail($id)
    {
        return fractal(Kiosks::find($id), new KioskTransformer())->includeKioskActivity()->respond(200);
    }

    public function getEmployeeActivity($personGroupId, $personId)
    {
        $response = array();
        $person = FacePerson::where('personId', $personId)->where('personGroupId', $personGroupId)->first();
        if ($person) {
            $employee = $person->employee;
            if ($employee) {

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['employeeActivityData'] = fractal($employee, new EmployeeLastActivityTransfomer());

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['EMPLOYEE_NOT_FOUND'];
                $response['message'] = 'Unable to find employee';
            }
        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['PERSON DATA NOT FOUND'];
            $response['message'] = 'Unable to find person data';
        }

        return response()->json($response, 200);
    }

    public function getEmployeeAccess($employeeId)
    {
        $response =array();
        $user = User::where('employeeId',$employeeId)->first();
        if($user){
            if($user->hasPermissionTo('access kiosk setting')){
                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Access granted';
            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['UNAUTHORIZED_ACCESS'];
                $response['message'] = 'User has no access';
            }
        }
        else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['USER NOT FOUND'];
            $response['message'] = 'Unable to find user data';
        }

        return response()->json($response,200);
    }

    public function getEmployeeActivityByEmployeeNo($employeeNo)
    {
        $response = array();
        $employee = MasterEmployee::where('employeeNo',$employeeNo)->first();
        if ($employee) {

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['employeeActivityData'] = fractal($employee, new EmployeeLastActivityTransfomer());
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['EMPLOYEE_NOT_FOUND'];
            $response['message'] = 'Unable to find employee';
            return response()->json($response,200);
        }

    }

    public function checkKioskPasscode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kioskId' => 'required',
            'passcode' => 'required',
        ]);


        if ($validator->fails()) {
            $response = array();
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        // is valid

        $response = array();

        $kiosk = Kiosks::find($request->kioskId);

        if($kiosk){

            if($kiosk->passcode == $request->passcode){
                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['PASSCODE_NOT_MATCH'];
                $response['message'] = 'Kiosk passcode does not match';
            }

        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['KIOSK_NOT_FOUND'];
            $response['message'] = 'Kiosk not found';
        }

        return response()->json($response, 200);
    }

    public function saveLastHeartBeat($kioskId)
    {
        $kiosk = Kiosks::find($kioskId);

        if($kiosk){

            $kiosk->lastHeartBeat = Carbon::now()->format('d/m/Y H:i:s');
            $kiosk->save();

        }
    }

    public function saveBatteryStatus(Request $request, $kioskId)
    {
        $kiosk = Kiosks::find($kioskId);

        if($kiosk){
            $kiosk->batteryPower = ($request->batteryPower*100).'%';
            $kiosk->isCharging = $request->isCharging;
            $kiosk->save();;

        }
    }

}
