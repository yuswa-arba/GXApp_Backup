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

        $query = '';

        $year = $this->currentYear();

        if ($request->sortYear != '' && $request->sortYear != null) {
            $year = $request->sortYear;
        }


        if($request->leaveApprovalId!=null && $request->leaveApprovalId!=''){

            if($query!=''){
                $query .= ' and ';
            }

            $rawQueryLeaveApproval = ' leaveApprovalId = "' . $request->leaveApprovalId .'"';

            $query .= $rawQueryLeaveApproval;

        }

        if($request->leaveTypeId!=null && $request->leaveTypeId!=''){

            if($query!=''){
                $query .= ' and ';
            }

            $rawQueryLeaveType = ' leaveTypeId = "' . $request->leaveTypeId .'"';

            $query .= $rawQueryLeaveType;

        }

        if($query!=''){
            $leaveSchedule = EmployeeLeaveSchedule::whereRaw($query)->where('year',$year)->get();
        } else {
            $leaveSchedule = EmployeeLeaveSchedule::where('year',$year)->get();
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

        $query = '';

        $year = $this->currentYear();

        if ($request->sortYear != '' && $request->sortYear != null) {
            $year = $request->sortYear;
        }


        if($request->leaveApprovalId!=null && $request->leaveApprovalId!=''){

            if($query!=''){
                $query .= ' and ';
            }

            $rawQueryLeaveApproval = ' leaveApprovalId = "' . $request->leaveApprovalId .'"';

            $query .= $rawQueryLeaveApproval;

        }

        if($request->leaveTypeId!=null && $request->leaveTypeId!=''){

            if($query!=''){
                $query .= ' and ';
            }

            $rawQueryLeaveType = ' leaveTypeId = "' . $request->leaveTypeId .'"';

            $query .= $rawQueryLeaveType;

        }

        if($query!=''){
            $leaveSchedule = EmployeeLeaveSchedule::whereRaw($query)
                ->where('year',$year)
                ->whereIn('employeeId', $employeeIds)
                ->get();
        } else {
            $leaveSchedule = EmployeeLeaveSchedule::where('year',$year)
                ->whereIn('employeeId', $employeeIds)
                ->get();
        }

        return fractal($leaveSchedule, new EmployeeLeaveScheduleListTransformer());

    }
}