<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Transformers\EmployeeBonusCutTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class GenerateSalaryLogic extends GenerateUseCase
{

    use GlobalUtils;

    public function handle($request)
    {
        /* Date range array*/
        $dateRange = $this->generateDateRange($request->fromDate, $request->toDate, 'd/m/Y');

        /* Get employee that is still active */
        $employeeIds = MasterEmployee::where('hasResigned', 0)->get()->pluck('id');

        /* Get attendance timesheet Ids*/
        $employeeAttdTimesheet = array();
        foreach ($employeeIds as $employeeId) {
            foreach ($dateRange as $date){

                /* Filter timesheet remove Holiday & Leave
                 * 1. Get slot ID if assigned, else use 1 (general)
                 * 2. Check if date exist in day off schedule table based on slotId, if it does, don't include it in array
                 * 3. Check date in employee leave schedule, if exist, don't include it in array //TODO : employee leave schedule still not working
                 *
                */

                $slotId = 1; // default

                // if slot Id found, update slotId variable
                if($this->getEmployeeSlotId($employeeId)){
                    $slotId = $this->getEmployeeSlotId($employeeId);
                }

                // if its not day off and not employee leave schedule then insert date to array
                if(!$this->isDayOffForThisSlot($slotId,$date) && !$this->employeeLeaveSchedule($employeeIds,$date)){

                    $timesheetId =  AttendanceTimesheet::where('employeeId',$employeeId)->where('clockInDate',$date)->first()['id'];
                    $employeeAttdTimesheet[$employeeId]['timesheets'][$date] = $timesheetId;

                }

            }
        }

        echo json_encode($employeeAttdTimesheet);

    }

    private function getEmployeeSlotId($employeeId)
    {
        $employeeSlotSchedule = EmployeeSlotSchedule::where('employeeId',$employeeId)->first();

        // if employee assigned to slot return slotId
        if($employeeSlotSchedule){
            return $employeeSlotSchedule->slotId;
        }

        // else return null
        return null;

    }

    private function isDayOffForThisSlot($slotId, $date)
    {

        $checkDayOffSchedule =  DayOffSchedule::where('slotId',$slotId)->where('date',$date)->count();

        // if day off schedule found return TRUE
        if($checkDayOffSchedule>0){
            return true;
        }

        // else return FALSE
        return false;

    }

    private function employeeLeaveSchedule($employeeIds, $date)
    {
        //TODO: CHECK IF THIS SPECIFIC DATE IS EMPLOYEE LEAVE SCHEDULE
        return false;
    }

}