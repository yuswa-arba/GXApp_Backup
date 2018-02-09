<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Shift;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\ExchangeShiftEmployee;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Traits\FirebaseUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Traits\GlobalConfig;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ExchangeShiftLogic extends ExchangeShiftUseCase
{
    use GlobalUtils;
    use FirebaseUtils;

    public function handleAttemptExchangeWorkingDay($request)
    {
        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        //get Job Position ID, ony take shift from employee with the same job position
        $jobPositionId = $this->getResultWithNullChecker1Connection($employee, 'employment', 'jobPositionId');

        // Requester slotID
        $requesterSlotId = $employee->slotSchedule->slotId ?: 1; //else use default slot

        // Requester shift ID
        $requesterShiftId = $employee->slotSchedule->slot->shiftSchedule->where('date', $request->fromDate)->first()['shiftId'] ?: 1; //else use default shift

        // Possible Exchange
        $possibleExchanges = array();

        // Check if fromDate is day off
        if ($jobPositionId) {

            $possibleEmployeeIds = Employment::where('jobPositionId', $jobPositionId)->get()->pluck('employeeId');

            // Get Slot Ids
            $possibleEmployees = MasterEmployee::whereIn('id', $possibleEmployeeIds)->where('id', '!=', $employee->id)->get(); //do not include self

            $i = 0;

            foreach ($possibleEmployees as $possibleEmployee) {

                $slotId = $this->getResultWithNullChecker1Connection($possibleEmployee, 'slotSchedule', 'slotId');

                if ($slotId) {
                    // Make sure this slot is not multiple assigned to other users
                    if (EmployeeSlotSchedule::where('employeeId', '!=', $possibleEmployee->id)->where('slotId', $slotId)->count() == 0) {

                        // Get Slot Shift Schedule if exist
                        $slotShiftSchedule = SlotShiftSchedule::where('slotId', $slotId)->where('date', $request->fromDate)->first();

                        if ($slotShiftSchedule) { // Check if this employee assigned to specific shift this date

                            $possibleExchanges[$i]['employeeId'] = $possibleEmployee->id;
                            $possibleExchanges[$i]['employeeName'] = $possibleEmployee->givenName;
                            $possibleExchanges[$i]['shiftId'] = $slotShiftSchedule->shiftId;
                            $possibleExchanges[$i]['shiftDetails'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'name') . ' (' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workStartAt') . ' - ' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workEndAt') . ')';
                            $possibleExchanges[$i]['slotId'] = $slotShiftSchedule->slotId;
                            $possibleExchanges[$i]['slotName'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'slot', 'name');
                            $possibleExchanges[$i]['date'] = $slotShiftSchedule->date;
                            $possibleExchanges[$i]['isDayOff'] = 0;
                            $possibleExchanges[$i]['dayOffName'] = null;

                            $i++; //increment

                        } else { // else use General shift

                            if ($requesterShiftId != 1) { // Make sure only get this if only requester shift id is not the same (general)

                                $generalShift = Shifts::find(1);

                                $possibleExchanges[$i]['employeeId'] = $possibleEmployee->id;
                                $possibleExchanges[$i]['employeeName'] = $possibleEmployee->givenName;
                                $possibleExchanges[$i]['shiftId'] = 1;
                                $possibleExchanges[$i]['shiftDetails'] = $generalShift->name . ' (' . $generalShift->workStartAt . '-' . $generalShift->workEndAt . ')';
                                $possibleExchanges[$i]['slotId'] = $slotId;
                                $possibleExchanges[$i]['slotName'] = Slots::find($slotId)->name;
                                $possibleExchanges[$i]['date'] = $request->fromDate;
                                $possibleExchanges[$i]['isDayOff'] = 0;
                                $possibleExchanges[$i]['dayOffName'] = null;

                                $i++; //increment
                            }

                        }
                    }
                }


            }

            /* Success Response */
            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['possibleExchangeResponse']['data'] = $possibleExchanges;

            return response()->json($response, 200);

        } else {

            /* Error Response */
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['JOB_POSITION_ID_NOT_DEFINED'];
            $response['message'] = 'Job Position ID is not defined';

            return response()->json($response, 200);
        }
    }

    public function handleAttemptExchangeDayOff($request)
    {
        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        //get Job Position ID, ony take shift from employee with the same job position
        $jobPositionId = $this->getResultWithNullChecker1Connection($employee, 'employment', 'jobPositionId');

        // Possible Exchange
        $possibleExchanges = array();

        // Check if fromDate is day off
        if ($jobPositionId) {

            $possibleEmployeeIds = Employment::where('jobPositionId', $jobPositionId)->get()->pluck('employeeId');

            // Get Slot Ids
            $possibleEmployees = MasterEmployee::whereIn('id', $possibleEmployeeIds)->where('id', '!=', $employee->id)->get(); //do not include self

            $j = 0;

            foreach ($possibleEmployees as $possibleEmployee) {

                $slotId = $this->getResultWithNullChecker1Connection($possibleEmployee, 'slotSchedule', 'slotId'); //default general slot

                if ($slotId) {
                    // Make sure this slot is not multiple assigned to other users
                    if (EmployeeSlotSchedule::where('employeeId', '!=', $possibleEmployee->id)->where('slotId', $slotId)->count() == 0) {

                        $dayOffSchedules = DayOffSchedule::where('slotId', $slotId)->where('date', '!=', $request->fromDate)->where('date', $request->toDate)->get();

                        foreach ($dayOffSchedules as $dayOffSchedule) {

                            if ($dayOffSchedule->date && $request->fromDate) { // Make sure dates are not empty

                                $parseFromDate = Carbon::createFromFormat('d/m/Y', $request->fromDate);
                                $parseDayOffDate = Carbon::createFromFormat('d/m/Y', $dayOffSchedule->date);

                                // Make sure day off dates is greater than today and it's in current year
                                if ($parseDayOffDate->gt(Carbon::now()) && $parseDayOffDate->year == $parseFromDate->year) {

                                    $possibleExchanges[$j]['employeeId'] = $possibleEmployee->id;
                                    $possibleExchanges[$j]['employeeName'] = $possibleEmployee->givenName;
                                    $possibleExchanges[$j]['shiftId'] = ""; //require empty value
                                    $possibleExchanges[$j]['shiftDetails'] = ""; //require empty value
                                    $possibleExchanges[$j]['slotId'] = $slotId;
                                    $possibleExchanges[$j]['slotName'] = Slots::find($slotId)->name;
                                    $possibleExchanges[$j]['date'] = $dayOffSchedule->date;
                                    $possibleExchanges[$j]['isDayOff'] = 1;
                                    $possibleExchanges[$j]['dayOffName'] = $dayOffSchedule->description;

                                    $j++;//increment

                                }

                            }
                        }
                    }
                }
            }

            /* Success Response */
            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['possibleExchangeResponse']['data'] = $possibleExchanges;

            return response()->json($response, 200);

        } else {

            /* Error Response */
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['JOB_POSITION_ID_NOT_DEFINED'];
            $response['message'] = 'Job Position ID is not defined';

            return response()->json($response, 200);
        }
    }


    public function handleRequestExchange($request)
    {

        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        if ($employee) {

            $insertRequest = ExchangeShiftEmployee::updateOrCreate(
                [
                    'employeeId1' => $employee->id,
                    'fromShiftId' => $request->fromShiftId,
                    'fromDate' => $request->fromDate
                ],
                [
                    'employeeId2' => $request->ownerEmployeeId,
                    'toShiftId' => $request->toShiftId,
                    'toDate' => $request->toDate
                ]
            );

            if ($insertRequest) {

                //TODO send notification to manager

                // Send Notification to shift's owner
                $ownerShift = MasterEmployee::find($request->ownerEmployeeId);

                if ($ownerShift) {

                    $ownerShiftUserId = $this->getResultWithNullChecker1Connection($ownerShift, 'user', 'id');

                    /* Send push notification */
                    app()->make('PushNotificationService')->singleNotify([
                        'userID' => $ownerShiftUserId,
                        'title' => 'Exchange Shift',
                        'message' => 'Someone has requested to change shift with you!',
                        'sendToType' => GlobalConfig::$TOKEN_TYPE['ANDROID'],
                        'intentType' => GlobalConfig::$FCM_INTENT_TYPE['HOME'],
                        'viaType' => GlobalConfig::$NOTIFY_TYPE['NOTIFICATION'],
                        'sender' => $user
                    ]);

                    /* Success Response */
                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Success';

                    return response()->json($response, 200);

                } else {

                    /* Error Response */
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
                    $response['message'] = 'Owner shift employee data not found';

                    return response()->json($response, 200);
                }

            } else {

                /* Error Response */
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                $response['message'] = 'Unable to save data';

                return response()->json($response, 200);
            }

        } else {
            /* Error Response */
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
            $response['message'] = 'Employee data not found';
            return response()->json($response, 200);
        }
    }

    public function handleAnswerRequest($request)
    {

        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        if ($employee) {
            $exchangeReq = ExchangeShiftEmployee::find($request->exchangeShiftId);

            if ($exchangeReq->employeeId2 == $employee->id) { //Check if this user is authorized to answer request

                if ($request->confirmType == 'accept') {

                    $requesterSlotId = $this->getResultWithNullChecker1Connection($exchangeReq->requesterEmployee, 'slotSchedule', 'slotId') ?: 1;
                    $ownerSlotId = $this->getResultWithNullChecker1Connection($exchangeReq->ownerEmployee, 'slotSchedule', 'slotId') ?: 1;

                    if ($requesterSlotId != 1 && $ownerSlotId != 1) { //Make sure its not General Slot that is being traded

                        if ($this->isDayOffForThisSlot($requesterSlotId, $exchangeReq->fromDate) && $this->isDayOffForThisSlot($ownerSlotId, $exchangeReq->toDate)) {

                            $exchangeDayOffFrom = DayOffSchedule::where('slotId',$requesterSlotId)
                                                 ->where('date',$exchangeReq->fromDate)
                                                 ->first();
                            $exchangeDayOffTo = DayOffSchedule::where('slotId',$ownerSlotId)
                                                ->where('date',$exchangeReq->toDate)
                                                ->first();

                            if($exchangeDayOffFrom&&$exchangeDayOffTo){

                                // Save requester
                                $exchangeDayOffFrom->slotId = $ownerSlotId;
                                $exchangeDayOffFrom->date = $exchangeReq->toDate;

                                // Save owner
                                $exchangeDayOffTo->slotId=$requesterSlotId;
                                $exchangeDayOffTo->date = $exchangeReq->fromDate;


                                if($exchangeDayOffFrom->save() && $exchangeDayOffTo->save()){

                                    //Update exchange shift employee data
                                    $exchangeReq->confirmType = ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['CONFIRM'];//confirmed
                                    $exchangeReq->confirmedDate = Carbon::now()->format('d/m/Y');
                                    $exchangeReq->confirmedTime = Carbon::now()->format('H:i');

                                    if ($exchangeReq->save()) {

                                        // Notify requester
                                        $requesterUserId = $this->getResultWithNullChecker1Connection($exchangeReq->requesterEmployee, 'user', 'id');

                                        /* Send push notification */
                                        app()->make('PushNotificationService')->singleNotify([
                                            'userID' => $requesterUserId,
                                            'title' => 'Exchange Shift Accepted',
                                            'message' => 'Your exchange shift request has been accepted!',
                                            'sendToType' => GlobalConfig::$TOKEN_TYPE['ANDROID'],
                                            'intentType' => GlobalConfig::$FCM_INTENT_TYPE['HOME'],
                                            'viaType' => GlobalConfig::$NOTIFY_TYPE['NOTIFICATION'],
                                            'sender' => $user
                                        ]);

                                        /*Success response*/
                                        $response['isFailed'] = false;
                                        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                                        $response['message'] = 'Success';

                                        return response()->json($response, 200);
                                    } else {
                                        /*Error repsonse*/
                                        $response['isFailed'] = true;
                                        $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                                        $response['message'] = 'Unable to save exchange shift table';

                                        return response()->json($response, 200);
                                    }


                                } else {
                                    /*Error repsonse*/
                                    $response['isFailed'] = true;
                                    $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                                    $response['message'] = 'Unable to save exchange data';

                                    return response()->json($response, 200);
                                }



                            } else {
                                /*Error repsonse*/
                                $response['isFailed'] = true;
                                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNABLE_TO_GET_EXCHANGE_SHIFTS_DATA'];
                                $response['message'] = 'Unable to get exchange shifts data';

                                return response()->json($response, 200);
                            }



                        } elseif (!$this->isDayOffForThisSlot($requesterSlotId, $exchangeReq->fromDate) && !$this->isDayOffForThisSlot($ownerSlotId, $exchangeReq->toDate)) {

                            //HANDLE WORK DAY EXCHANGE

                            $exchangeShiftFrom = SlotShiftSchedule::where('slotId', $requesterSlotId)
                                ->where('shiftId', $exchangeReq->fromShiftId)
                                ->where('date', $exchangeReq->fromDate)
                                ->where('confirmType', 0)
                                ->first();

                            $exchangeShiftTo = SlotShiftSchedule::where('slotId', $ownerSlotId)
                                ->where('shiftId', $exchangeReq->toShiftId)
                                ->where('date', $exchangeReq->toDate)
                                ->where('confirmType', 0)
                                ->first();

                            if ($exchangeShiftFrom && $exchangeShiftTo) {

                                // Save requester
                                $exchangeShiftFrom->slotId = $ownerSlotId;
                                $exchangeShiftFrom->shiftId = $exchangeReq->toShiftId;

                                //Save owner
                                $exchangeShiftTo->slotId = $requesterSlotId;
                                $exchangeShiftTo->shiftId = $exchangeReq->fromShiftId;

                                if ($exchangeShiftFrom->save() && $exchangeShiftTo->save()) {

                                    //Update exchange shift employee data
                                    $exchangeReq->confirmType = ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['CONFIRM'];//confirmed
                                    $exchangeReq->confirmedDate = Carbon::now()->format('d/m/Y');
                                    $exchangeReq->confirmedTime = Carbon::now()->format('H:i');

                                    if ($exchangeReq->save()) {

                                        // Notify requester
                                        $requesterUserId = $this->getResultWithNullChecker1Connection($exchangeReq->requesterEmployee, 'user', 'id');

                                        /* Send push notification */
                                        app()->make('PushNotificationService')->singleNotify([
                                            'userID' => $requesterUserId,
                                            'title' => 'Exchange Shift Accepted',
                                            'message' => 'Your exchange shift request has been accepted!',
                                            'sendToType' => GlobalConfig::$TOKEN_TYPE['ANDROID'],
                                            'intentType' => GlobalConfig::$FCM_INTENT_TYPE['HOME'],
                                            'viaType' => GlobalConfig::$NOTIFY_TYPE['NOTIFICATION'],
                                            'sender' => $user
                                        ]);

                                        /*Success response*/
                                        $response['isFailed'] = false;
                                        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                                        $response['message'] = 'Success';

                                        return response()->json($response, 200);
                                    } else {
                                        /*Error repsonse*/
                                        $response['isFailed'] = true;
                                        $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                                        $response['message'] = 'Unable to save exchange shift table';

                                        return response()->json($response, 200);
                                    }


                                } else {
                                    /*Error repsonse*/
                                    $response['isFailed'] = true;
                                    $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                                    $response['message'] = 'Unable to save exchange data';

                                    return response()->json($response, 200);

                                }

                            } else {
                                /*Error repsonse*/
                                $response['isFailed'] = true;
                                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNABLE_TO_GET_EXCHANGE_SHIFTS_DATA'];
                                $response['message'] = 'Unable to get exchange shifts data';

                                return response()->json($response, 200);
                            }

                        } else {

                            /* Save invalid request */
                            $exchangeReq->confirmType = ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['INVALID'];
                            $exchangeReq->confirmedDate = Carbon::now()->format('d/m/Y');
                            $exchangeReq->confirmedTime = Carbon::now()->format('H:i');
                            $exchangeReq->save();

                            /*Error repsonse*/
                            $response['isFailed'] = true;
                            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['INVALID_EXCHANGE_REQUEST'];
                            $response['message'] = 'Invalid exchange request';

                            return response()->json($response, 200);
                        }

                    }  else { // ERROR RESPONSE , GENERAL SLOT IS BEING TRADED

                        /* Save invalid request */
                        $exchangeReq->confirmType = ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['INVALID'];
                        $exchangeReq->confirmedDate = Carbon::now()->format('d/m/Y');
                        $exchangeReq->confirmedTime = Carbon::now()->format('H:i');
                        $exchangeReq->save();

                        /*Error repsonse*/
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ATTD_ERR_CODES['INVALID_EXCHANGE_REQUEST'];
                        $response['message'] = 'Invalid exchange request. General Slot cannot be traded';

                        return response()->json($response, 200);
                    }



                } elseif ($request->confirmType == 'decline') { // DECLINE REQUEST

                    // Notify requester that owner is declining the request
                    $requesterUserId = $this->getResultWithNullChecker1Connection($exchangeReq->requesterEmployee, 'user', 'id');

                    /* Send push notification */
                    app()->make('PushNotificationService')->singleNotify([
                        'userID' => $requesterUserId,
                        'title' => 'Exchange Shift Declined',
                        'message' => $this->getResultWithNullChecker1Connection($exchangeReq, 'requesterEmployee', 'givenName') . ' has declined your exchange shift request.',
                        'sendToType' => GlobalConfig::$TOKEN_TYPE['ANDROID'],
                        'intentType' => GlobalConfig::$FCM_INTENT_TYPE['HOME'],
                        'viaType' => GlobalConfig::$NOTIFY_TYPE['NOTIFICATION'],
                        'sender' => $user
                    ]);


                    //Update exchange shift employee data
                    $exchangeReq->confirmType = ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['DECLINE'];//declined
                    $exchangeReq->confirmedDate = Carbon::now()->format('d/m/Y');
                    $exchangeReq->confirmedTime = Carbon::now()->format('H:i');

                    // Decline request
                    if ($exchangeReq->save()) {

                        /* Success response */
                        $response['isFailed'] = false;
                        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                        $response['message'] = 'Success';

                        return response()->json($response, 200);

                    } else {
                        /* Error Response */
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                        $response['message'] = 'Unable to delete data';
                        return response()->json($response, 200);
                    }

                } else {

                    /* Error repsonse */
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNDEFINED_EXCHANGE_CONFIRMATION_TYPE'];
                    $response['message'] = 'Undefined confirmation type';

                    return response()->json($response, 200);

                }
            } else {
                /* Error repsonse */
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['UNAUTHORIZED_TO_ANSWER_EXCHANGE'];
                $response['message'] = 'User is not authorized to answer';

                return response()->json($response, 200);
            }
        } else {
            /* Error Response */
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
            $response['message'] = 'Employee data not found';
            return response()->json($response, 200);
        }

    }

    private function isDayOffForThisSlot($slotId, $date)
    {

        $checkDayOffSchedule = DayOffSchedule::where('slotId', $slotId)->where('date', $date)->count();

        // if day off schedule found return TRUE
        if ($checkDayOffSchedule > 0) {
            return true;
        }

        // else return FALSE
        return false;
    }


}
