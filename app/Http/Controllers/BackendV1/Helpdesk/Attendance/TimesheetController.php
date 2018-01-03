<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\GetTimesheetListLogic;
use App\Attendance\Models\AttendanceTimesheet;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{

    public function list(Request $request)
    {
        return GetTimesheetListLogic::getData($request);
    }

    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(),['timesheetId'=>'required']);
        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet ID Required';
            return response()->json($response, 200);
        }

        $approveTimesheet  = AttendanceTimesheet::find($request->timesheetId);
        if($approveTimesheet){
            $approveTimesheet->attendanceApproveId = 1;
            $approveTimesheet->approvedBy = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';
            $approveTimesheet->save();

            $response['isFailed'] = false;
            $response['message'] = 'Timesheet has been approved';
            $response['approvedBy'] =!is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';
            return response()->json($response, 200);

        } else{
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet not found';
            return response()->json($response, 200);
        }

    }

}
