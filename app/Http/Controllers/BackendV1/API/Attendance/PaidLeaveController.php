<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Attendance\Logics\LeaveSchedule\InsertEmployeeLeaveScheduleLogic;
use App\Attendance\Logics\Shift\ExchangeShiftLogic;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\ExchangeShiftEmployee;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\DayOffSingleCalendarAPITransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Attendance\Transformers\ExchangeShiftEmployeeTransformer;
use App\Attendance\Transformers\KioskTransformer;
use App\Attendance\Transformers\ShiftListTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarAPITransformer;
use App\Employee\Models\FacePerson;
use App\Employee\Transformers\EmployeeLastActivityTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;


class PaidLeaveController extends Controller
{

    use GlobalUtils;
    use ApiUtils;

    public function insert(Request $request)
    {
        $response = array();
        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            $validator = Validator::make($request->all(), [
                'fromDate' => 'date_format:"d/m/Y"|required',
                'toDate' => 'date_format:"d/m/Y"|required',
                'leaveTypeId' => 'required',
            ]);

            if ($validator->fails()) {
                $response['isFailed'] = true;
                $response['message'] = 'Required parameter is missing';
                return response()->json($response, 200);
            }

            //is valid

            return InsertEmployeeLeaveScheduleLogic::insert($request,$employee);

        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }

    }
}