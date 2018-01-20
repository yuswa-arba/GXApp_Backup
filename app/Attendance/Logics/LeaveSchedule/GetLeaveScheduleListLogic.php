<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\LeaveSchedule;

use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\EmployeeLeaveScheduleListTransformer;
use App\Attendance\Transformers\SlotListTransformer;
use App\Employee\Models\Employment;
use App\Traits\GlobalUtils;

class GetLeaveScheduleListLogic extends GetLeaveScheduleUseCase
{
    use GlobalUtils;


    public function handleAllELS($request)
    {

        $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())->get();


        if($request->leaveApprovalId && $request->leaveTypeId){
            $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())
                ->where('leaveApprovalId', $request->leaveApprovalId)
                ->where('leaveTypeId', $request->leaveTypeId)
                ->get();
        }

        if($request->leaveApprovalId && !$request->leaveTypeId){
            $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())
                ->where('leaveApprovalId', $request->leaveApprovalId)
                ->get();
        }

        if(!$request->leaveApprovalId && $request->leaveTypeId){
            $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())
                ->where('leaveTypeId', $request->leaveTypeId)
                ->get();
        }


        return fractal($leaveSchedule, new EmployeeLeaveScheduleListTransformer());

    }


    public function handlELSWithSpecificDivision($request)
    {
        // Get employees with specific division
        $employments = Employment::where('divisionId', $request->divisionId)->get();
        $employeeIds = array();

        foreach ($employments as $employment) {
            //push employee id to array
            array_push($employeeIds, $employment->employeeId);
        }

        $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())->get();


        if($request->leaveApprovalId && $request->leaveTypeId){
            $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())
                ->where('leaveApprovalId', $request->leaveApprovalId)
                ->where('leaveTypeId', $request->leaveTypeId)
                ->whereIn('employeeId',$employeeIds)
                ->get();
        }

        if($request->leaveApprovalId && !$request->leaveTypeId){
            $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())
                ->where('leaveApprovalId', $request->leaveApprovalId)
                ->whereIn('employeeId',$employeeIds)
                ->get();
        }

        if(!$request->leaveApprovalId && $request->leaveTypeId){
            $leaveSchedule = EmployeeLeaveSchedule::where('created_at', $this->currentYear())
                ->where('leaveTypeId', $request->leaveTypeId)
                ->whereIn('employeeId',$employeeIds)
                ->get();
        }


        return fractal($leaveSchedule, new EmployeeLeaveScheduleListTransformer());


    }
}