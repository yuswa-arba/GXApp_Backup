<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Shift;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\ExchangeShiftEmployee;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\DayOffMappingCalendarTransformer;
use App\Attendance\Transformers\ShiftScheduleMappingCalendarTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\API\Traits\FirebaseUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ExchangeShiftLogic extends ExchangeShiftUseCase
{
    use GlobalUtils;
    use FirebaseUtils;

    /*
     * @desc : get data that wants to be replaced
     *
     * */
    public function handleAttemptExchange($request)
    {
        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        if ($employee) {

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

                if ($this->checkIfFromDateIsDayOff($requesterSlotId, $request->fromDate)) {

                    //TODO: FIND POSSIBLE EMPLOYEE THAT HAVE THE SAME DAY OFFS

                } else {

                    $i = 0;

                    foreach ($possibleEmployees as $possibleEmployee) {

                        $slotId = $this->getResultWithNullChecker1Connection($possibleEmployee, 'slotSchedule', 'slotId');
                        $shiftId = $possibleEmployee->slotSchedule->slot->shiftSchedule->where('date', $request->toDate)->first()['shiftId'] ?: 1; //else use default shift

                        // Get Slot Shift Schedule
                        $slotShiftSchedule = SlotShiftSchedule::where('slotId', $slotId)->where('date', $request->toDate)->first();

                        if ($request->fromDate == $request->toDate) {

                            if ($requesterShiftId != $shiftId) { // Make sure requester shift ID and possible exchange shift ID is not the same if on the same day

                                if ($slotShiftSchedule) { // Insert to possible exchanges array

                                    $possibleExchanges[$i]['employeeId'] = $possibleEmployee->id;
                                    $possibleExchanges[$i]['employeeName'] = $possibleEmployee->givenName;
                                    $possibleExchanges[$i]['shiftId'] = $slotShiftSchedule->shiftId;
                                    $possibleExchanges[$i]['shiftDetails'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'name') . ' (' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workStartAt') . ' - ' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workEndAt') . ')';
                                    $possibleExchanges[$i]['slotId'] = $slotShiftSchedule->slotId;
                                    $possibleExchanges[$i]['slotName'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'slot', 'name');
                                    $possibleExchanges[$i]['date'] = $request->toDate;

                                } else { // General

                                    if ($requesterShiftId != 1) { // Make sure only get this if only requester shift id is not the same (general)

                                        $generalSlot = Slots::find(1);
                                        $generalShift = Shifts::find(1);

                                        $possibleExchanges[$i]['employeeId'] = $possibleEmployee->id;
                                        $possibleExchanges[$i]['employeeName'] = $possibleEmployee->givenName;
                                        $possibleExchanges[$i]['shiftId'] = 1;
                                        $possibleExchanges[$i]['shiftDetails'] = $generalShift->name . ' (' . $generalShift->workStartAt . '-' . $generalShift->workEndAt . ')';
                                        $possibleExchanges[$i]['slotId'] = 1;
                                        $possibleExchanges[$i]['slotName'] = $generalSlot->name;
                                        $possibleExchanges[$i]['date'] = $request->toDate;

                                    }
                                }
                            }

                        } else {

                            if ($slotShiftSchedule) { // Insert to possible exchanges array

                                $possibleExchanges[$i]['employeeId'] = $possibleEmployee->id;
                                $possibleExchanges[$i]['employeeName'] = $possibleEmployee->givenName;
                                $possibleExchanges[$i]['shiftId'] = $slotShiftSchedule->shiftId;
                                $possibleExchanges[$i]['shiftDetails'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'name') . ' (' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workStartAt') . ' - ' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workEndAt') . ')';
                                $possibleExchanges[$i]['slotId'] = $slotShiftSchedule->slotId;
                                $possibleExchanges[$i]['slotName'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'slot', 'name');
                                $possibleExchanges[$i]['date'] = $request->toDate;

                            } else { // General

                                if ($requesterShiftId != 1) { // Make sure only get this if only requester shift id is not the same (general)

                                    $generalSlot = Slots::find(1);
                                    $generalShift = Shifts::find(1);

                                    $possibleExchanges[$i]['employeeId'] = $possibleEmployee->id;
                                    $possibleExchanges[$i]['employeeName'] = $possibleEmployee->givenName;
                                    $possibleExchanges[$i]['shiftId'] = 1;
                                    $possibleExchanges[$i]['shiftDetails'] = $generalShift->name . ' (' . $generalShift->workStartAt . '-' . $generalShift->workEndAt . ')';
                                    $possibleExchanges[$i]['slotId'] = 1;
                                    $possibleExchanges[$i]['slotName'] = $generalSlot->name;
                                    $possibleExchanges[$i]['date'] = $request->toDate;

                                }
                            }
                            $i++;
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

        } else {
            /* Error Response */
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
            $response['message'] = 'Employee data not found';
            return response()->json($response, 200);
        }

    }

    public function handleRequestExchange($request){

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
                $ownerShiftUserId = $this->getResultWithNullChecker1Connection(MasterEmployee::find($request->ownerEmployeeId), 'user', 'id');

                $this->sendSinglePush($ownerShiftUserId,
                    'Exchange Shift',
                    'Someone has requested to change shift with you!',
                    null, //image url
                    ConfigCodes::$TOKEN_TYPE['ANDROID'],
                    ConfigCodes::$FCM_INTENT_TYPE['HOME']
                );

                /* Success Response */
                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';

                return response()->json($response, 200);

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

    public function handleAnswerRequest($request){

        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        if ($employee) {
            $exchangeShift = ExchangeShiftEmployee::find($request->exchangeShiftId);

            if ($exchangeShift->employeeId2 == $employee->id) { //Check if this user is authorized to answer request

                if ($request->confirmType == 'accept') {

                    $requesterSlotId = $this->getResultWithNullChecker1Connection($exchangeShift->requesterEmployee, 'slotSchedule', 'slotId');
                    $ownerSlotId = $this->getResultWithNullChecker1Connection($exchangeShift->ownerEmployee, 'slotSchedule', 'slotId');

                    $exchangeFrom = SlotShiftSchedule::where('slotId', $requesterSlotId)
                        ->where('shiftId', $exchangeShift->fromShiftId)
                        ->where('date', $exchangeShift->fromDate)
                        ->where('isConfirmed', 0)
                        ->first();

                    $exchangeTo = SlotShiftSchedule::where('slotId', $ownerSlotId)
                        ->where('shiftId', $exchangeShift->toShiftId)
                        ->where('date', $exchangeShift->toDate)
                        ->where('isConfirmed', 0)
                        ->first();

                    if ($exchangeFrom && $exchangeTo) {

                        // Save requester
                        $exchangeFrom->slotId = $ownerSlotId;
                        $exchangeFrom->shiftId = $exchangeShift->toShiftId;

                        //Save owner
                        $exchangeTo->slotId = $requesterSlotId;
                        $exchangeTo->shiftId = $exchangeShift->fromShiftId;

                        if ($exchangeFrom->save() && $exchangeTo->save()) {

                            //Update exchange shift employee data
                            $exchangeShift->isConfirmed = 1;//confirmed
                            $exchangeShift->confirmedDate = Carbon::now()->format('d/m/Y');
                            $exchangeShift->confirmedTime = Carbon::now()->format('H:i');

                            if ($exchangeShift->save()) {

                                // Notify requester
                                $requesterUserId = $this->getResultWithNullChecker1Connection($exchangeShift->requesterEmployee, 'user', 'id');
                                $this->sendSinglePush(
                                    $requesterUserId,
                                    'Exchange Shift Accepted',
                                    'Your exchange shift request has been accepted!',
                                    null,
                                    ConfigCodes::$TOKEN_TYPE['ANDROID'],
                                    ConfigCodes::$FCM_INTENT_TYPE['HOME']
                                );

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

                } elseif ($request->confirmType == 'decline') { // DECLINE REQUEST

                    // Notify requester that owner is declining the request
                    $requesterUserId = $this->getResultWithNullChecker1Connection($exchangeShift->requesterEmployee, 'user', 'id');
                    $this->sendSinglePush(
                        $requesterUserId,
                        'Exchange Shift Declined',
                        null, //image url
                        $this->getResultWithNullChecker1Connection($exchangeShift, 'requesterEmployee', 'givenName') . ' has declined your exchange shift request.',
                        ConfigCodes::$TOKEN_TYPE['ANDROID'],
                        ConfigCodes::$FCM_INTENT_TYPE['HOME']
                    );

                    // Decline request = delete
                    if ($exchangeShift->delete()) {

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