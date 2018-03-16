<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\LeaveSchedule;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Traits\GlobalConfig;
use App\Traits\GlobalUtils;
use Carbon\Carbon;

class InsertEmployeeLeaveScheduleLogic extends InsertELSUseCase
{
    use GlobalUtils;

    public function handle($request,$employee)
    {
        $isStreakPaidLeave = false;
        // Parse date to use Carbon
        $parsedFromDate = Carbon::createFromFormat('d/m/Y',$request->fromDate);
        $parsedToDate = Carbon::createFromFormat('d/m/Y',$request->toDate);

        $totalSubmittedDate = $this->getTotalAlreadySubmittedDate($employee);

        if($totalSubmittedDate<GlobalConfig::$MAX_PAID_LEAVE['DAYS']){ //make sure paid leave is still available



            if($this->isDateGreater($request->fromDate,$request->toDate)){

                if($this->totalDays($request->fromDate,$request->toDate)>1){ // check if its more than 1 date
                    $isStreakPaidLeave = true; // if yes set streak paid leave to true
                }

                if($isStreakPaidLeave){ //if its streak paid leave check if he has already used the chance

                    if($this->hasUsedStreakPaidLeaveChance($employee)){ //check if he has already used the chance
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ATTD_ERR_CODES['HAS_USED_CHANCE_TO_STREAK_PAID_LEAVE'];
                        $response['message'] = 'You have used the chance to streak paid leave this year';
                        return response()->json($response,200);
                    }

                }

                if($this->checkIfCurrentMonthPaidLeaveExist($employee,$parsedFromDate->month)){
                    if(!$isStreakPaidLeave){ // if its not streak paid leave and this month already exist

                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ATTD_ERR_CODES['ALREADY_HAS_PAID_LEAVE_IN_CURRENT_MONTH'];
                        $response['message'] = 'You already have paid leave in this month';
                        return response()->json($response,200);

                    }
                }

                // TODO : check in the same division / slot if exist on the same date

                // so far valid..

                $insert = EmployeeLeaveSchedule::create([
                    'employeeId'=>$employee->id,
                    'fromDate'=>$parsedFromDate->format('d/m/Y'),
                    'toDate'=>$parsedToDate->format('d/m/Y'),
                    'leaveApprovalId' => ConfigCodes::$LEAVE_APPROVAL['WAITING_FOR_APPROVAL'],
                    'leaveTypeId'=>$request->leaveTypeId,
                    'description'=>$request->description,
                    'month'=>$parsedFromDate->month,
                    'year'=>$parsedToDate->year,
                    'totalDays'=>$this->totalDays($request->fromDate,$request->toDate),
                    'isStreakPaidLeave'>>$isStreakPaidLeave?1:0
                ]);

                if($insert){

                    // TODO : notify admin and managers

                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Success';

                    return response()->json($response,200);

                } else {

                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                    $response['message'] = 'An error occurred. Unable to save paid leave';
                    return response()->json($response,200);

                }

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['REACHED_MAXIMUM_PAID_LEAVE'];
                $response['message'] = 'You have reached your maximum paid leave days';
                return response()->json($response,200);
            }



        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['REACHED_MAXIMUM_PAID_LEAVE'];
            $response['message'] = 'You have reached your maximum paid leave days';
            return response()->json($response,200);
        }


    }

    private function getTotalAlreadySubmittedDate($employee)
    {
        return EmployeeLeaveSchedule::where('employeeId',$employee->id)
            ->where('year',Carbon::now()->year) //current year
            ->where('leaveApprovalId','!=',ConfigCodes::$LEAVE_APPROVAL['DISAPPROVED'])
            ->count();
    }

    private function hasUsedStreakPaidLeaveChance($employee)
    {
        return EmployeeLeaveSchedule::where('employeeId',$employee->id)
            ->where('year',Carbon::now()->year)
            ->where('isStreakPaidLeave',1)
            ->count()>0;

    }

    private function checkIfCurrentMonthPaidLeaveExist($employee, $month)
    {
        return EmployeeLeaveSchedule::where('employeeId',$employee->id)
                ->where('year',Carbon::now()->year)
                ->where('month',$month)
                ->count()>0;
    }
}