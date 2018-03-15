<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
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


class ShiftController extends Controller
{

    use GlobalUtils;
    use ApiUtils;


    /*
       |--------------------------------------
       | Logic to Exchange Shift v 0.1.0
       |--------------------------------------
       | see : https://github.com/globalxtreme/GXApp_Employee_Server/wiki/Exchange-Shift-Day-off-Logic
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

                    $dayOffSchedule = DayOffSchedule::where('slotId', $requesterSlotId)->where('date', $request->fromDate)->first();

                    //is day off
                    $response['isFailed'] = false;
                    $response['message'] = 'Success';
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['isDayOff'] = 1;
                    $response['dayOffName'] = $dayOffSchedule->description?:null;
                    $response['isPublicHoliday'] = 0;
                    $response['publicHolidayName']=null;

                    return response()->json($response, 200);

                } else if ($this->checkIfFromDateIsPublicHoliday($requesterSlotId, $request->fromDate)) {

                    if (Carbon::now()->addDays(2)->gt($parseFromDate)) { //check if today is valid to exchange day offs

                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ATTD_ERR_CODES['3_DAYS_BEFORE_EXCHANGE_DAY_OFF'];
                        $response['message'] = 'Unable to exchange this day off. (min. 3 days before requested date)';

                        return response()->json($response, 200);
                    }

                    //is valid

                    $publicHolidaySchedule = PublicHolidaySchedule::where('fromSlotId', $requesterSlotId)->where('applyDate', $request->fromDate)->first();

                    //is day off
                    $response['isFailed'] = false;
                    $response['message'] = 'Success';
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['isDayOff'] = 0;
                    $response['dayOffName'] = null;
                    $response['isPublicHoliday'] = 1;
                    $response['publicHolidayName']=$this->getResultWithNullChecker1Connection($publicHolidaySchedule,'publicHoliday','name');

                    return response()->json($response, 200);

                } else {

                    //is not day off
                    $response['isFailed'] = false;
                    $response['message'] = 'Success';
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['isDayOff'] = 0;
                    $response['isPublicHoliday'] = 0;

                    return response()->json($response, 200);

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

                $validator = Validator::make($request->all(), ['fromDate' => 'required', 'toDate' => 'required']);

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

    public function attemptExchangePublicHoliday(Request $request)
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

                //is valid

                return ExchangeShiftLogic::attemptExchangePublicHoliday($request);

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
                'ownerEmployeeId' => 'required',
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
                'answerType' => 'required',
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


    /*
     * @desc : get exchange shift data that is REQUESTED TO YOU
     * */
    public function incomingExchangeList()
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            if ($employee) {

                $exchangeShifts = ExchangeShiftEmployee::where('employeeId2', $employee->id)->orderBy('id', 'desc')->get();

                if ($exchangeShifts) {

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Success';
                    $response['exchangeShiftRequestResponse'] = fractal($exchangeShifts, new ExchangeShiftEmployeeTransformer());

                    return response()->json($response, 200);

                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EXCHANGE_SHIFT_DATA_NOT_FOUND'];
                    $response['message'] = 'Data not found';

                    return response()->json($response, 200);
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


    /*
     * @desc : get exchange shift data that is REQUESTED BY YOU
     * */
    public function outgoingExchangeList()
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            if ($employee) {

                $exchangeShifts = ExchangeShiftEmployee::where('employeeId1', $employee->id)->orderBy('id', 'desc')->get();

                if ($exchangeShifts) {

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Success';
                    $response['exchangeShiftRequestResponse'] = fractal($exchangeShifts, new ExchangeShiftEmployeeTransformer());

                    return response()->json($response, 200);

                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EXCHANGE_SHIFT_DATA_NOT_FOUND'];
                    $response['message'] = 'Data not found';

                    return response()->json($response, 200);
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


    /*
     * @desc display display user's today and tomorrow shift
     * */
    public function getTodayAndTomorrowShift()
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            if ($employee) {

                $slotId = 1;//default slotId
                $todayShiftId = 1;//default shiftId
                $tomorrowShiftId = 1;//default shiftId
                $todayIsDayOff = false; //default
                $todayIsPublicHoliday = false; //default
                $tomorrowIsDayOff = false; //default tomorrow
                $tomorrowIsPublicHoliday = false; //default tomorrow

                $employeeSlotSchedule = EmployeeSlotSchedule::where('employeeId', $employee->id)->first();

                if ($employeeSlotSchedule != null) {

                    $slot = $employeeSlotSchedule->slot;
                    $slotId = $slot->id;

                    /* Get shift ID if exist*/
                    $todaySlotShiftSchedule = SlotShiftSchedule::where('slotId', $slot->id)->where('date', Carbon::now()->format('d/m/Y'))->first(['shiftId']);
                    $tomorrowSlotShiftSchedule = SlotShiftSchedule::where('slotId', $slot->id)->where('date', Carbon::now()->addDay()->format('d/m/Y'))->first(['shiftId']);

                    /* Set shift id if slot is assigned to specific shif*/
                    if ($todaySlotShiftSchedule != null) {
                        $todayShiftId = $todaySlotShiftSchedule->shiftId;
                    }

                    if ($tomorrowSlotShiftSchedule != null) {
                        $tomorrowShiftId = $tomorrowSlotShiftSchedule->shiftId;
                    }

                    /* If slot is not using Mapping or is Deleted set to default shift */
                    if (!$slot->isUsingMapping || $slot->isDeleted) {
                        $todayShiftId = 1; // use default shift ID
                        $tomorrowShiftId = 1;// use default shift ID
                    }

                }

                /* Check public holidays and day off for this slot */
                $todayDayOffSchedule = DayOffSchedule::where('slotId', $slotId)->where('date', Carbon::now()->format('d/m/Y'))->first();
                $tomorrowDayOffSchedule = DayOffSchedule::where('slotId', $slotId)->where('date', Carbon::now()->addDay()->format('d/m/Y'))->first();

                if ($todayDayOffSchedule != null) {
                    $todayIsDayOff  = true;
                }

                if ($tomorrowDayOffSchedule != null) {
                    $tomorrowIsDayOff  = true;
                }

                $todayPublicHolidaySchedule = PublicHolidaySchedule::where('fromSlotId', $slotId)->where('applyDate',Carbon::now()->format('d/m/Y'))->first();
                $tomorrowPublicHolidaySchedule = PublicHolidaySchedule::where('fromSlotId', $slotId)->where('applyDate',Carbon::now()->addDay()->format('d/m/Y'))->first();

                if($todayPublicHolidaySchedule!=null){
                    $todayIsPublicHoliday = true;
                }

                if($tomorrowPublicHolidaySchedule!=null){
                    $tomorrowIsPublicHoliday = true;
                }

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['todayIsDafOff'] = $todayIsDayOff;
                $response['tomorrowIsDayOff'] = $tomorrowIsDayOff;
                $response['todayIsPublicHoliday']  =$todayIsPublicHoliday;
                $response['tomorrowIsPublicHoliday'] = $tomorrowIsPublicHoliday;
                $response['todayShiftResponse'] = fractal(Shifts::find($todayShiftId),new ShiftListTransformer());
                $response['tomorrowShiftResponse'] = fractal(Shifts::find($tomorrowShiftId),new ShiftListTransformer());

                return response()->json($response,200);

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


    //UTILS
    private function checkIfFromDateIsDayOff($requesterSlotId, $fromDate)
    {
        $checkDayOff = DayOffSchedule::where('slotId', $requesterSlotId)->where('date', $fromDate)->count();
        if ($checkDayOff > 0) {
            return true;
        } else {
            return false;
        }

    }

    private function checkIfFromDateIsPublicHoliday($requesterSlotId, $fromDate)
    {
        $checkPublicHoliday = PublicHolidaySchedule::where('fromSlotId', $requesterSlotId)->where('applyDate', $fromDate)->count();
        if ($checkPublicHoliday > 0) {
            return true;
        } else {
            return false;
        }
    }


}
