<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\LeaveSchedule;

use App\Attendance\Models\AttendanceSetting;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Traits\GlobalConfig;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InsertEmployeeLeaveScheduleLogic extends InsertELSUseCase
{
    use GlobalUtils;

    public function handle($request, $employee)
    {


        if ($this->isEmployeeEligible($employee)) { // check if employee is eligible for paid leave (has work for 2 years at least)

            $isStreakPaidLeave = false;
            // Parse date to use Carbon
            $parsedFromDate = Carbon::createFromFormat('d/m/Y', $request->fromDate);
            $parsedToDate = Carbon::createFromFormat('d/m/Y', $request->toDate);

            $totalSubmittedDate = $this->getTotalAlreadySubmittedDate($employee, $parsedFromDate->year);

            if ($totalSubmittedDate <  AttendanceSetting::where('name','max-leave-days')->first()['value']) { //make sure paid leave is still available


                if ($this->isDateGreater($request->fromDate, $request->toDate) || ($request->fromDate == $request->toDate)) {

                    if ($this->isDateGreater(Carbon::now()->format('d/m/Y'), $request->fromDate) //greater than today
                    ) {
                        if ($this->diffDay($request->fromDate, $request->toDate) > 1) { // check if its more than 1 date
                            $isStreakPaidLeave = true; // if yes set streak paid leave to true
                        }

                        if ($isStreakPaidLeave) { //if its streak paid leave check if he has already used the chance

                            if ($this->hasUsedStreakPaidLeaveChance($employee, $parsedFromDate->year)) { //check if he has already used the chance

                                $response['isFailed'] = true;
                                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['HAS_USED_CHANCE_TO_STREAK_PAID_LEAVE'];
                                $response['message'] = 'You have used the chance to streak paid leave this year';
                                return response()->json($response, 200);

                            }

                            $maxStreakPaidLeaveDays= AttendanceSetting::where('name','max-streak-paid-leave')->first()['value'];
                            if ($this->diffDay($request->fromDate, $request->toDate) >  $maxStreakPaidLeaveDays) { // check max streak days

                                $response['isFailed'] = true;
                                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['STREAK_PAID_LEAVE_MORE_THAN_7'];
                                $response['message'] = 'Streak paid leave cannot be more than ' . $maxStreakPaidLeaveDays . ' days ';
                                return response()->json($response, 200);

                            }

                        }

                        if ($this->checkIfCurrentMonthPaidLeaveExist($employee, $parsedFromDate->month, $parsedFromDate->year)) {
                            if (!$isStreakPaidLeave) { // if its not streak paid leave and this month already exist

                                $response['isFailed'] = true;
                                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['ALREADY_HAS_PAID_LEAVE_IN_CURRENT_MONTH'];
                                $response['message'] = 'You already have paid leave in this month';
                                return response()->json($response, 200);

                            }
                        }

                        $checkSameJobPosition = $this->checkIfSameDivisionHasPaidLeave($employee, $request->fromDate, $request->toDate, $isStreakPaidLeave);

                        if ($checkSameJobPosition['error']) {
                            $response['isFailed'] = true;
                            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_WITH_SAME_DIVISION_PAID_LEAVE'];
                            $response['message'] = 'Invalid date found: ' . $checkSameJobPosition['date'] . '. It has been taken by your colleague';
                            return response()->json($response, 200);
                        }

                        // so far valid..

                        $insert = EmployeeLeaveSchedule::create([
                            'employeeId' => $employee->id,
                            'fromDate' => $parsedFromDate->format('d/m/Y'),
                            'toDate' => $parsedToDate->format('d/m/Y'),
                            'leaveApprovalId' => ConfigCodes::$LEAVE_APPROVAL['WAITING_FOR_APPROVAL'],
                            'leaveTypeId' => $request->leaveTypeId,
                            'description' => $request->description,
                            'month' => $parsedFromDate->month,
                            'year' => $parsedToDate->year,
                            'totalDays' => $isStreakPaidLeave ? $this->totalDays($request->fromDate, $request->toDate) : 1,
                            'isStreakPaidLeave' => $isStreakPaidLeave ? 1 : 0
                        ]);

                        if ($insert) {

                            // TODO : notify admin and managers

                            $response['isFailed'] = false;
                            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                            $response['message'] = 'Success';

                            return response()->json($response, 200);

                        } else {

                            $response['isFailed'] = true;
                            $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                            $response['message'] = 'An error occurred. Unable to save paid leave';
                            return response()->json($response, 200);

                        }
                    } else {
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ATTD_ERR_CODES['INVALID_DATE'];
                        $response['message'] = 'Invalid date';

                        return response()->json($response, 200);
                    }


                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ATTD_ERR_CODES['INVALID_DATE'];
                    $response['message'] = 'Invalid selected date. Make sure to date is same or greater than from date';
                    return response()->json($response, 200);
                }

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['REACHED_MAXIMUM_PAID_LEAVE'];
                $response['message'] = 'You have reached your maximum paid leave days. Total Requested: ' . $totalSubmittedDate;
                return response()->json($response, 200);
            }
        } else {

            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['NOT_ELIGIBLE_FOR_PAID_LEAVE'];
            $response['message'] = 'You are not eligible for paid leave';

            return response()->json($response, 200);
        }


    }

    private function getTotalAlreadySubmittedDate($employee, $year)
    {
        return EmployeeLeaveSchedule::where('employeeId', $employee->id)
            ->where('year', $year)//current year
            ->where('leaveApprovalId', '!=', ConfigCodes::$LEAVE_APPROVAL['DISAPPROVED'])
            ->sum('totalDays');
    }

    private function hasUsedStreakPaidLeaveChance($employee, $year)
    {
        return EmployeeLeaveSchedule::where('employeeId', $employee->id)
                ->where('year', $year)
                ->where('isStreakPaidLeave', 1)
                ->count() > 0;

    }

    private function checkIfCurrentMonthPaidLeaveExist($employee, $month, $year)
    {
        return EmployeeLeaveSchedule::where('employeeId', $employee->id)
                ->where('year', $year)
                ->where('month', $month)
                ->count() > 0;
    }

    private function checkIfSameDivisionHasPaidLeave($employee, $fromDate, $toDate, $isStreakPaidLeave)
    {

        $employeeDivisionId = $this->getResultWithNullChecker1Connection($employee, 'employment', 'divisionId');

        if ($employeeDivisionId != null) {

            $getEmployeeIds = MasterEmployee::select('MasterEmployee.id')->where('hasResigned', 0)
                ->join('employment', function ($join) use ($employeeDivisionId) {
                    $join->on('MasterEmployee.id', '=', 'employment.employeeId')
                        ->where('employment.divisionId', '=', $employeeDivisionId);
                })->get()->toArray();


            $employeeIdsWithSameDivision = array_column($getEmployeeIds, 'id');

            if ($employeeIdsWithSameDivision) {

                if ($isStreakPaidLeave) {

                    $generatedDates = $this->generateDateRange($fromDate, $toDate, 'd/m/Y');

                    if (count($generatedDates) > 0) {

                        $error = false;
                        $invalidDate = '';

                        foreach ($generatedDates as $date) { //loop through generated dates

                            $schedule = EmployeeLeaveSchedule::whereIn('employeeId', $employeeIdsWithSameDivision)
                                    ->where('fromDate', $date)
                                    ->where('leaveApprovalId', ConfigCodes::$LEAVE_APPROVAL['APPROVED'])
                                    ->count() > 0;

                            if ($schedule) {
                                $invalidDate = $date;
                                $error = true; //set error to true;
                                break;
                            }
                        }

                        return ['error' => $error, 'date' => $invalidDate];

                    } else {
                        return ['error' => true, 'date' => ''];
                    }

                } else {
                    $invalidDate = '';
                    $error = false;

                    $schedule = EmployeeLeaveSchedule::whereIn('employeeId', $employeeIdsWithSameDivision)
                            ->where('fromDate', $fromDate)
                            ->where('leaveApprovalId', ConfigCodes::$LEAVE_APPROVAL['APPROVED'])
                            ->count() > 0;

                    if ($schedule) {
                        $invalidDate = $fromDate;
                        $error = true; //set error to true;
                    }
                    return ['error' => $error, 'date' => $invalidDate];
                }
            } else {
                return ['error' => true, 'date' => ''];
            }
        } else {
            return ['error' => true, 'date' => ''];
        }

    }

    private function isEmployeeEligible($employee)
    {
        $employment = $employee->employment;

        if ($employment) {

            $parsedDateOfStart = Carbon::createFromFormat('d/m/Y', $employment->dateOfStart);
            $currentYear = Carbon::now()->year;

            return (int)$currentYear - (int)$parsedDateOfStart->year >= GlobalConfig::$ELIGIBLE_DAYS_FOR_PAID_LEAVE['YEARS'];

        } else {
            return false;
        }

    }


}