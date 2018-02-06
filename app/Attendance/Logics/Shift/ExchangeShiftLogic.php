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

            // Requester shift ID
            $requesterShiftId = $employee->slotSchedule->slot->shiftSchedule->where('date', $request->date)->first()['shiftId'];


            if ($jobPositionId) {

                $possibleExchanges = array();

                $possibleEmployeeIds = Employment::where('jobPositionId', $jobPositionId)->get()->pluck('employeeId');

                // Get Slot Ids
                $possibleEmployees = MasterEmployee::whereIn('id', $possibleEmployeeIds)->get();


                $i = 0;
                foreach ($possibleEmployees as $possibleEmployee) {

                    $slotId = $this->getResultWithNullChecker1Connection($possibleEmployee, 'slotSchedule', 'slotId');
                    $shiftId = $possibleEmployee->slotSchedule->slot->shiftSchedule->where('date', $request->date)->first()['shiftId'];


                    if ($requesterShiftId != $shiftId) { // Make sure requester shift ID and possible exchange shift ID is not the same

                        // Get Slot Shift Schedule
                        $slotShiftSchedule = SlotShiftSchedule::where('slotId', $slotId)->where('date', $request->date)->first();

                        // Insert to possible exchanges array
                        if ($slotShiftSchedule) {

                            $possibleExchanges[$i]['employeeId'] = $possibleEmployee->id;
                            $possibleExchanges[$i]['employeeName'] = $possibleEmployee->givenName;
                            $possibleExchanges[$i]['shiftId'] = $slotShiftSchedule->shiftId;
                            $possibleExchanges[$i]['shiftDetails'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'name') . ' (' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workStartAt') . ' - ' . $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'shift', 'workEndAt') . ')';
                            $possibleExchanges[$i]['slotId'] = $slotShiftSchedule->slotId;
                            $possibleExchanges[$i]['slotName'] = $this->getResultWithNullChecker1Connection($slotShiftSchedule, 'slot', 'name');
                            $possibleExchanges[$i]['date'] = $request->date;

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
                                $possibleExchanges[$i]['date'] = $request->date;

                            }

                        }
                        $i++;
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
                    'date' => $request->date
                ],
                [
                    'employeeId2' => $request->ownerEmployeeId,
                    'toShiftId' => $request->toShiftId
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

    public function handleAnswerRequest($request)
    {

        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        if ($employee) {
            $exchangeShift = ExchangeShiftEmployee::find($request->exchangeShiftId);

            if ($exchangeShift->employeeId2 == $employee->id) {


                if ($request->confirmType == 'accept') {

                    //TODO: accept exchange request

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
}