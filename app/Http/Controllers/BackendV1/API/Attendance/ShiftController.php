<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Attendance\Logics\Shift\ExchangeShiftLogic;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\DayOffSingleCalendarAPITransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;


class ShiftController extends Controller
{

    use GlobalUtils;
    use ApiUtils;


    /*
       |--------------------------------------
       | Logic to Exchange Shift v 0.1.0
       |--------------------------------------
       | * Check day off call
       |--------------------------------------
       | 1. Check requester type request, is it day off or not
       |--------------------------------------
       | * Attempt Exchange call
       |--------------------------------------
       | 1. Requester can only exchange shift on the same date
       | 2. If the date being exchange is a "day-off" date, it can only be exchange
       |    with another "day-off" of other employees and does not have to be on the same date
       | 3. @return it will give list of possible exchange , and user will then pick which
       |    possible exchange they want to trade -> call Request Exchange
       |--------------------------------------
       | * Request Exchange call
       |--------------------------------------
       | 1. Request Exchange will only save the requester exchange into exchangeShiftEmployee table and
       | 2. Notify the shift's owner that someone has requested to exchange with their shift
       | 3. Shift's owner answers -> Accept/Decline -> call Answer Exchange
       |--------------------------------------
       | * Answer Exchange call
       |--------------------------------------
       | 1. Define confirmation type (accept/decline)
       | 2. If it's decline , remove data from exchangeShiftEmployee table and notify requester -> finish()
       | 3. If it's accept , run the logic :
       |    - define if fromDate is day-off or working day
       |    - if day off , trade the data between requester and owner in dayOffSchedule table
       |    - if working day, trade the data between requester and owner in slotShiftSchedule table,
       |      if exchange is from/to general shift, remove the data from slotShiftSchedule table,
       |      this is because anything that is not in slotShiftSchedule or dayOffSchedule table is
       |      considered as general shift (8-17)
       |
    */

    public function attemptCheckDate(Request $request)
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            if ($employee) {

                // Requester slotID
                $requesterSlotId = $employee->slotSchedule->slotId ?: 1; //else use default slot

                $validator = Validator::make($request->all(), ['fromDate' => 'required']);

                if ($validator->fails()) {

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                    $response['message'] = 'Required parameter is missing';

                    return response()->json($response, 200);
                }

                $parseFromDate = Carbon::createFromFormat('d/m/Y', $request->fromDate);

                if ($parseFromDate->lt(Carbon::now())) { // validate request must be greater than today's date

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNABLE_TO_CHANGE_PAST_DATES'];
                    $response['message'] = 'Unable to change past dates';
                    return response()->json($response, 200);

                }


                if ($this->checkIfFromDateIsDayOff($requesterSlotId, $request->fromDate)) { // check if date click is day off or not

                    if (Carbon::now()->addDays(2)->gt($parseFromDate)) { //check if today is valid to exchange day offs

                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ATTD_ERR_CODES['3_DAYS_BEFORE_EXCHANGE_DAY_OFF'];
                        $response['message'] = 'Unable to exchange this day off. (min. 3 days before requested date)';

                        return response()->json($response, 200);
                    }

                    //is valid

                    //is day off
                    $response['isFailed'] = false;
                    $response['message'] = 'Success';
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['isDayOff'] = 1;

                    return response()->json($response,200);

                } else {

                    //is not day off
                    $response['isFailed'] = false;
                    $response['message'] = 'Success';
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['isDayOff'] = 0;

                    return response()->json($response,200);

                }

            } else {
                /* Error Response */
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
                $response['message'] = 'Employee data not found';
                return response()->json($response, 200);
            }

        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    public function attemptExchangeWorkingDay(Request $request)
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            if ($employee) {

                // Requester slotID
                $requesterSlotId = $employee->slotSchedule->slotId ?: 1; //else use default slot

                $validator = Validator::make($request->all(), ['fromDate' => 'required']);

                if ($validator->fails()) {

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                    $response['message'] = 'Required parameter is missing';

                    return response()->json($response, 200);
                }

                //is valid

                return ExchangeShiftLogic::attemptExchangeWorkingDay($request);

            } else {
                /* Error Response */
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
                $response['message'] = 'Employee data not found';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    public function attemptExchangeDayOff(Request $request)
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            if ($employee) {

                // Requester slotID
                $requesterSlotId = $employee->slotSchedule->slotId ?: 1; //else use default slot

                $validator = Validator::make($request->all(), ['fromDate' => 'required','toDate'=>'required']);

                if ($validator->fails()) {

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                    $response['message'] = 'Required parameter is missing';

                    return response()->json($response, 200);
                }

                $parseFromDate = Carbon::createFromFormat('d/m/Y', $request->fromDate);

                if ($parseFromDate->lt(Carbon::now())) { // validate request must be greater than today's date

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNABLE_TO_CHANGE_PAST_DATES'];
                    $response['message'] = 'Unable to change past dates';
                    return response()->json($response, 200);

                }

                //is valid

                return ExchangeShiftLogic::attemptExchangeDayOff($request);

            } else {
                /* Error Response */
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
                $response['message'] = 'Employee data not found';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    public function requestExchange(Request $request)
    {

        $response = array();

        if ($this->checkUserEmployee()) {

            $validator = Validator::make($request->all(), [
                'fromDate' => 'required',
                'toDate' => 'required',
                'fromShiftId' => 'required',
                'requesterSlotId' => 'required',
                'ownerEmployeeId' => 'required',
                'toShiftId' => 'required'
            ]);

            if ($validator->fails()) {

                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                $response['message'] = 'Required parameter is missing';

                return response()->json($response, 200);
            }

            //is valid

            return ExchangeShiftLogic::requestExchange($request);


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    public function answerExchange(Request $request)
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $validator = Validator::make($request->all(), [
                'confirmType' => 'required',
                'exchangeShiftId' => 'required'
            ]);

            if ($validator->fails()) {

                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                $response['message'] = 'Required parameter is missing';

                return response()->json($response, 200);
            }

            //is valid

            return ExchangeShiftLogic::answerRequestExchange($request);


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }


    private function checkIfFromDateIsDayOff($requesterSlotId, $fromDate)
    {
        $checkDayOff = DayOffSchedule::where('slotId', $requesterSlotId)->where('date', $fromDate)->count();
        if ($checkDayOff > 0) {
            return true;
        } else {
            return false;
        }

    }


}
