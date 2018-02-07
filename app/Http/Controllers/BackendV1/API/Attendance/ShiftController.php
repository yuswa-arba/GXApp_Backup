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


    public function attemptExchange(Request $request)
    {

        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee
            $response = array();

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

                if ($this->checkIfFromDateIsDayOff($requesterSlotId, $request->fromDate)) { // check if date click is day off or not

                    //is valid

                    return ExchangeShiftLogic::attemptExchangeDayOff($request);

                } else {

                    $validator = Validator::make($request->all(), ['fromDate' => 'required', 'toDate' => 'required']);

                    if ($validator->fails()) {

                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                        $response['message'] = 'Required parameter is missing';

                        return response()->json($response, 200);
                    }

                    //is valid

                    return ExchangeShiftLogic::attemptExchangeWorkingDay($request);

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
