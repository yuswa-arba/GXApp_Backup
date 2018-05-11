<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Attendance\Logics\LeaveSchedule\InsertEmployeeLeaveScheduleLogic;
use App\Attendance\Models\AttendanceSetting;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\LeaveType;
use App\Attendance\Transformers\EmployeeLeaveBriefTransformer;
use App\Components\Transformers\BasicComponentTrasnformer;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Traits\GlobalConfig;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PaidLeaveController extends Controller
{

    use GlobalUtils;
    use ApiUtils;

    public function list(Request $request)
    {
        $response = array();
        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            $year = Carbon::now()->year;
            if ($request->year) {
                $year = $request->year;
            }

            $paidLeaveSchedules = EmployeeLeaveSchedule::where('employeeId', $employee->id)->where('year', $year)->get();

            if ($paidLeaveSchedules) {

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['paidLeaveResponse'] = fractal($paidLeaveSchedules, new EmployeeLeaveBriefTransformer());

                return response()->json($response, 200);
            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['NO_PAID_LEAVE_DATA'];
                $response['message'] = 'Unable to find paid leave data';

                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }

    }

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
        if ($request->year) {
            $year = $request->year;
        }

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            // Get total paid leave request this user has made
            $totalRequest = EmployeeLeaveSchedule::where('employeeId', $employee->id)
                ->where('year', $year)
                ->sum('totalDays');

            // Check if user has used streak paid leave chance
            $countStreakPaidLeave = 0;
            if ($this->hasUsedStreakPaidLeaveChance($employee, $year)) {
                $countStreakPaidLeave = 1;
            }

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['maxPaidLeaveDays'] =  AttendanceSetting::where('name','max-leave-days')->first()['value'];
            $response['totalRequest'] = $totalRequest;
            $response['maxStreakPaidLeaveChance'] = 1;
            $response['countStreakPaidLeave'] = $countStreakPaidLeave;
            $response['onYear'] = $year;

            return response()->json($response, 200);


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

    private function hasUsedStreakPaidLeaveChance($employee, $year)
    {
        return EmployeeLeaveSchedule::where('employeeId', $employee->id)
                ->where('year', $year)
                ->where('isStreakPaidLeave', 1)
                ->count() > 0;

    }

    public function removePaidLeave(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'elsId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid
        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee

        $leaveSchedule = EmployeeLeaveSchedule::where('id', $request->elsId)->where('employeeId', $employee->id)->first();

        if ($leaveSchedule) {

            //remove if valid

            $parsedFromDate = Carbon::createFromFormat('d/m/Y', $leaveSchedule->fromDate);

            if ($parsedFromDate->gt(Carbon::now())) {

                //logging
                app()->make('LogService')->logging([
                    'causer' => $employee->givenName,
                    'via' => 'web client| api client',
                    'subject' => 'Paid Leave',
                    'action' => 'delete',
                    'level' => 3,
                    'description' => 'Attempt to remove paid leave request. Id: ' . $leaveSchedule->id,
                    'causerIPAddress' => \Request::ip()
                ]);

                if ($leaveSchedule->delete()) {

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Success';

                    return response()->json($response,200);

                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                    $response['message'] = 'Unable to delete data';
                    return response()->json($response, 200);
                }

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNABLE_TO_REMOVE_REQUEST'];
                $response['message'] = 'Unable to remove paid leave';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['NO_PAID_LEAVE_DATA'];
            $response['message'] = 'Unable to find leave schedule data';

            return response()->json($response, 200);
        }

    }
}