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
use App\Attendance\Models\PublicHoliday;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Traits\FirebaseUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
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

                        //Make sure its not this employee day off
                        if (!$this->isDayOffForThisSlot($slotId, $request->fromDate)) {

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
                                $possibleExchanges[$i]['isPublicHoliday'] = 0;
                                $possibleExchanges[$i]['publicHolidayName'] = null;

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
                                    $possibleExchanges[$i]['isPublicHoliday'] = 0;
                                    $possibleExchanges[$i]['publicHolidayName'] = null;

                                    $i++; //increment
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
                                    $possibleExchanges[$j]['isPublicHoliday'] = 0;
                                    $possibleExchanges[$j]['publicHolidayName'] = null;

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

    public function handleAttemptExchangePublicHoliday($request)
    {
        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        $employeePublicHolidayId = PublicHolidaySchedule::where('applyDate', $request->fromDate)
            ->where('employeeId', $employee->id)
            ->orderBy('id', 'desc')->first()->pubHolidayId;

        // Possible Exchange
        $possibleExchanges = array();

        if ($employeePublicHolidayId) {

            $publicHolidaySchedules = PublicHolidaySchedule::where('pubHolidayId', $employeePublicHolidayId)
                ->where('employeeId', '!=', $employee->id)->get();  //dont include self

            $j = 0;

            foreach ($publicHolidaySchedules as $publicHolidaySchedule) {

                if ($publicHolidaySchedule->applyDate && $request->fromDate) { // Make sure dates are not empty

                    $parseFromDate = Carbon::createFromFormat('d/m/Y', $request->fromDate);
                    $parsePublicHolidayDate = Carbon::createFromFormat('d/m/Y', $publicHolidaySchedule->applyDate);

                    // Make sure day off dates is greater than today and it's in current year
                    if ($parsePublicHolidayDate->gt(Carbon::now()) && $parsePublicHolidayDate->year == $parseFromDate->year) {

                        $possibleExchanges[$j]['employeeId'] = $publicHolidaySchedule->employeeId;
                        $possibleExchanges[$j]['employeeName'] = $this->getResultWithNullChecker1Connection($publicHolidaySchedule, 'employee', 'givenName');
                        $possibleExchanges[$j]['shiftId'] = ""; //require empty value
                        $possibleExchanges[$j]['shiftDetails'] = ""; //require empty value
                        $possibleExchanges[$j]['slotId'] = $publicHolidaySchedule->fromSlotId;
                        $possibleExchanges[$j]['slotName'] = $this->getResultWithNullChecker1Connection($publicHolidaySchedule, 'slot', 'name');
                        $possibleExchanges[$j]['date'] = $publicHolidaySchedule->applyDate;
                        $possibleExchanges[$j]['isDayOff'] = 0;
                        $possibleExchanges[$j]['dayOffName'] = '';
                        $possibleExchanges[$j]['isPublicHoliday'] = 1;
                        $possibleExchanges[$j]['publicHolidayName'] = $this->getResultWithNullChecker1Connection($publicHolidaySchedule, 'publicHoliday', 'name');

                        $j++;//increment
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
            /* Errror response */
            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['PUBLIC_HOLIDAY_SCHEDULE_UNDEFINED'];
            $response['message'] = 'Unable to find public employee schedule ID';

            return response()->json($response, 200);
        }


    }

    public function handleRequestExchange($request)
    {

        $user = Auth::guard('api')->user(); //user
        $employee = $user->employee; // employee
        $response = array();

        if ($employee) {

            // Requester shift ID
            $requesterShiftId = $employee->slotSchedule->slot->shiftSchedule->where('date', $request->fromDate)->first()['shiftId'] ?: 1; //else use default shift

            // Requester slot ID
            $requesterSlotId = $this->getResultWithNullChecker1Connection($employee, 'slotSchedule', 'slotId') ?: 1;

            $ownerEmployee = MasterEmployee::find($request->ownerEmployeeId);

            // Owner Slot Id
            $ownerSlotId = $this->getResultWithNullChecker1Connection($ownerEmployee, 'slotSchedule', 'slotId') ?: 1;

            $isDayOff = 0; //default
            $isPublicHoliday = 0; //default
            $invalidRequest = 0; //default

            /* Validate dates */

            # check if its day off
            if ($this->isDayOffForThisSlot($requesterSlotId, $request->fromDate) && $this->isDayOffForThisSlot($ownerSlotId, $request->toDate)) {
                $isDayOff = 1;
                $requesterShiftId = '';//empty

            # check if its public holiady
            } elseif ($this->isPublicHolidayForThisSlot($requesterSlotId, $request->fromDate)&& $this->isPublicHolidayForThisSlot($ownerSlotId, $request->toDate)) {
                $isPublicHoliday = 1;
                $requesterShiftId = '';//empty

            # make sure its not day off
            }elseif (!$this->isDayOffForThisSlot($requesterSlotId, $request->fromDate) && !$this->isDayOffForThisSlot($ownerSlotId, $request->toDate)) {
                $isDayOff = 0;

            # make sure its not public holiday
            } elseif (!$this->isPublicHolidayForThisSlot($requesterSlotId, $request->fromDate) && !$this->isPublicHolidayForThisSlot($ownerSlotId, $request->toDate)) {
                $isPublicHoliday = 0;

            # invalid request
            } else {
                $invalidRequest = 1; // invalid
            }

            if ($invalidRequest == 0) { // if is valid

                $insertRequest = ExchangeShiftEmployee::updateOrCreate(
                    [
                        'employeeId1' => $employee->id,
                        'fromDate' => $request->fromDate,
                        'confirmType' => 0 //waiting
                    ],
                    [
                        'employeeId2' => $request->ownerEmployeeId,
                        'fromShiftId' => $requesterShiftId,
                        'toShiftId' => $request->toShiftId,
                        'toDate' => $request->toDate,
                        'isDayOff' => $isDayOff,
                        'isPublicHoliday'=>$isPublicHoliday
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
                            'intentType' => ConfigCodes::$FCM_INTENT_TYPE['HOME'],
                            'viaType' => ConfigCodes::$NOTIFY_TYPE['NOTIFICATION'],
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
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['INVALID_EXCHANGE_REQUEST'];
                $response['message'] = 'Invalid exchange dates';
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

                if ($request->answerType == ConfigCodes::$EXCHANGE_ANSWER_TYPE['ACCEPT']) {

                    $requesterSlotId = $this->getResultWithNullChecker1Connection($exchangeReq->requesterEmployee, 'slotSchedule', 'slotId') ?: 1;
                    $ownerSlotId = $this->getResultWithNullChecker1Connection($exchangeReq->ownerEmployee, 'slotSchedule', 'slotId') ?: 1;

                    if ($requesterSlotId != 1 && $ownerSlotId != 1) { //Make sure its not General Slot that is being traded

                        if ($this->isDayOffForThisSlot($requesterSlotId, $exchangeReq->fromDate) && $this->isDayOffForThisSlot($ownerSlotId, $exchangeReq->toDate)) {

                            //HANDLE DAY OFF EXCHANGE

                            $updateRequesterDayOff = DayOffSchedule::where('slotId', $requesterSlotId)
                                ->where('date', $exchangeReq->fromDate)
                                ->update(['date' => $exchangeReq->toDate]);

                            $updateOwnerDayOff = DayOffSchedule::where('slotId', $ownerSlotId)
                                ->where('date', $exchangeReq->toDate)
                                ->update(['date' => $exchangeReq->fromDate]);


                            if ($updateRequesterDayOff && $updateOwnerDayOff) {

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
                                        'title' => 'Exchange Day Off Accepted',
                                        'message' => 'Your exchange day off request has been accepted!',
                                        'intentType' => ConfigCodes::$FCM_INTENT_TYPE['HOME'],
                                        'viaType' => ConfigCodes::$NOTIFY_TYPE['NOTIFICATION'],
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

                        }elseif ($this->isPublicHolidayForThisSlot($requesterSlotId, $exchangeReq->fromDate) && $this->isPublicHolidayForThisSlot($ownerSlotId, $exchangeReq->toDate)) {

                            //HANDLE PUBLIC HOLIDAY EXCHANGE

                            $updateRequesterDayOff = PublicHolidaySchedule::where('fromSlotId', $requesterSlotId)
                                ->where('applyDate', $exchangeReq->fromDate)
                                ->where('employeeId',$exchangeReq->employeeId1)
                                ->update(['applyDate' => $exchangeReq->toDate]);

                            $updateOwnerDayOff = PublicHolidaySchedule::where('fromSlotId', $ownerSlotId)
                                ->where('applyDate', $exchangeReq->toDate)
                                ->where('employeeId',$exchangeReq->employeeId2)
                                ->update(['applyDate' => $exchangeReq->fromDate]);


                            if ($updateRequesterDayOff && $updateOwnerDayOff) {

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
                                        'title' => 'Exchange Public Holiday Accepted',
                                        'message' => 'Your exchange day off request has been accepted!',
                                        'intentType' => ConfigCodes::$FCM_INTENT_TYPE['HOME'],
                                        'viaType' => ConfigCodes::$NOTIFY_TYPE['NOTIFICATION'],
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

                        } elseif (!$this->isDayOffForThisSlot($requesterSlotId, $exchangeReq->fromDate) && !$this->isDayOffForThisSlot($ownerSlotId, $exchangeReq->toDate)) {

                            //HANDLE WORK DAY EXCHANGE

                            // If requester is changing to general shift ID just delete their
                            // data in slot shift schedule table, because general shift ID does not need
                            // to be inserted in the slot shift schedule table
                            if ($exchangeReq->toShiftId == 1) {
                                SlotShiftSchedule::where('slotId', $requesterSlotId)->where('date', $exchangeReq->fromDate)->delete();
                            }

                            // If owner is changing to general shift ID just delete their
                            // data in slot shift schedule table, because general shift ID does not need
                            // to be inserted in the slot shift schedule table
                            if ($exchangeReq->fromShiftId == 1) {
                                SlotShiftSchedule::where('slotId', $ownerSlotId)->where('date', $exchangeReq->toDate)->delete();
                            }

                            // If requester shift ID was general shift ID, do nothing
                            // else update or create the slot shift schedule
                            if ($exchangeReq->fromShiftId != 1) {
                                $updateOwnerSchedule = SlotShiftSchedule::updateOrCreate(
                                    ['date' => $exchangeReq->toDate, 'slotId' => $ownerSlotId],
                                    ['shiftId' => $exchangeReq->fromShiftId]
                                );
                            } else {
                                $updateOwnerSchedule = true;//do nothing
                            }

                            // If owner shift ID was general shift ID, do nothing
                            // else update or create the slot shift schedule
                            if ($exchangeReq->toShiftId != 1) {
                                $updateRequesterSchedule = SlotShiftSchedule::updateOrCreate(
                                    ['date' => $exchangeReq->fromDate, 'slotId' => $requesterSlotId],
                                    ['shiftId' => $exchangeReq->toShiftId]
                                );
                            } else {
                                $updateRequesterSchedule = true; //do nothing
                            }


                            if ($updateOwnerSchedule && $updateRequesterSchedule) {


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
                                        'intentType' => ConfigCodes::$FCM_INTENT_TYPE['HOME'],
                                        'viaType' => ConfigCodes::$NOTIFY_TYPE['NOTIFICATION'],
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
                                $response['message'] = 'Unable to update data';

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

                    } else { // ERROR RESPONSE , GENERAL SLOT IS BEING TRADED

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


                } elseif ($request->answerType == ConfigCodes::$EXCHANGE_ANSWER_TYPE['DECLINE']) { // DECLINE REQUEST

                    // Notify requester that owner is declining the request
                    $requesterUserId = $this->getResultWithNullChecker1Connection($exchangeReq->requesterEmployee, 'user', 'id');

                    /* Send push notification */
                    app()->make('PushNotificationService')->singleNotify([
                        'userID' => $requesterUserId,
                        'title' => 'Exchange Shift Declined',
                        'message' => $this->getResultWithNullChecker1Connection($exchangeReq, 'requesterEmployee', 'givenName') . ' has declined your exchange shift request.',
                        'intentType' => ConfigCodes::$FCM_INTENT_TYPE['HOME'],
                        'viaType' => ConfigCodes::$NOTIFY_TYPE['NOTIFICATION'],
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
        } else {
            return false;
        }

    }

    private function isPublicHolidayForThisSlot($requesterSlotId, $fromDate)
    {
        $checkPublicHoliday = PublicHolidaySchedule::where('fromSlotId', $requesterSlotId)->where('applyDate', $fromDate)->count();

        Log::info('rsID: '.$requesterSlotId);
        Log::info('fromDate: '.$fromDate);
        Log::info('cbh: '.$checkPublicHoliday);

        if ($checkPublicHoliday > 0) {
            return true;
        } else {
            return false;
        }
    }


}
