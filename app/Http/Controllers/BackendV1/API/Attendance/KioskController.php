<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Account\Traits\TokenUtils;
use App\Attendance\Logics\AttendanceLogic;
use App\Attendance\Logics\Kiosk\AuthenticationLogic;
use App\Attendance\Logics\Kiosk\KioskAuthLogic;
use App\Attendance\Models\KioskActivity;
use App\Attendance\Models\Kiosks;
use App\Attendance\Transformers\KioskTransformer;
use App\Employee\Models\FacePerson;
use App\Employee\Transformers\EmployeeLastActivityTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;


class KioskController extends Controller
{

    public function detail($id)
    {
        return fractal(Kiosks::find($id),new KioskTransformer())->includeKioskActivity()->respond(200);
    }

    public function getEmployeeActivity($personGroupId,$personId)
    {
        $response=  array();
        $person = FacePerson::where('personId',$personId)->where('personGroupId',$personGroupId)->first();
        if($person){
            $employee = $person->employee;
            if($employee){

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['employeeActivityData'] = fractal($employee,new EmployeeLastActivityTransfomer());

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

        return response()->json($response,200);



    }

}
