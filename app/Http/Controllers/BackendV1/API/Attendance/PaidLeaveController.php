<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Attendance\Logics\LeaveSchedule\InsertEmployeeLeaveScheduleLogic;
use App\Attendance\Logics\Shift\ExchangeShiftLogic;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\ExchangeShiftEmployee;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\LeaveType;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\DayOffSingleCalendarAPITransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Attendance\Transformers\ExchangeShiftEmployeeTransformer;
use App\Attendance\Transformers\KioskTransformer;
use App\Attendance\Transformers\ShiftListTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarAPITransformer;
use App\Components\Transformers\BasicComponentTrasnformer;
use App\Employee\Models\FacePerson;
use App\Employee\Transformers\EmployeeLastActivityTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Traits\GlobalConfig;
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

            return InsertEmployeeLeaveScheduleLogic::insert($request, $employee);

        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }

    }

    public function checkEligible()
    {
        $response = array();
        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee
            $employment = $employee->employment;//employment

            if ($employment) {

                $parsedDateOfStart = Carbon::createFromFormat('d/m/Y', $employment->dateOfStart);
                $currentYear = Carbon::now()->year;

                if ((int)$currentYear - (int)$parsedDateOfStart->year >= GlobalConfig::$ELIGIBLE_DAYS_FOR_PAID_LEAVE['YEARS']) {

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'You are eligible';

                    return response()->json($response, 200);

                } else {

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['NOT_ELIGIBLE_FOR_PAID_LEAVE'];
                    $response['message'] = 'You are not eligible for paid leave';

                    return response()->json($response, 200);

                }

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$USER_ERR_CODE['EMPLOYMENT_NOT_FOUND'];
                $response['message'] = 'Unable to find employment data';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }

    }


    public function getAvailability(Request $request)
    {
        $response = array();

        $year = Carbon::now()->year;
        if($request->year){
            $year = $request->year;
        }

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            // Get total paid leave request this user has made
            $totalRequest = EmployeeLeaveSchedule::where('employeeId', $employee->id)
                ->where('year', $year)
                ->orderBy('id', 'asc')
                ->take(12)
                ->count();

            // Check if user has used streak paid leave chance
            $countStreakPaidLeave = 0;
            if ($this->hasUsedStreakPaidLeaveChance($employee,$year)) {
                $countStreakPaidLeave = 1;
            }

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['maxPaidLeaveDays'] = GlobalConfig::$MAX_PAID_LEAVE['DAYS'];
            $response['totalRequest'] = $totalRequest;
            $response['maxStreakPaidLeaveChance'] = 1;
            $response['countStreakPaidLeave'] = $countStreakPaidLeave;
            $response['onYear']=$year;

            return response()->json($response,200);


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    public function paidLeaveType()
    {
        return fractal(LeaveType::all(), new BasicComponentTrasnformer())->respond(200);
    }

    private function hasUsedStreakPaidLeaveChance($employee,$year)
    {
        return EmployeeLeaveSchedule::where('employeeId', $employee->id)
                ->where('year',$year)
                ->where('isStreakPaidLeave', 1)
                ->count() > 0;

    }
}