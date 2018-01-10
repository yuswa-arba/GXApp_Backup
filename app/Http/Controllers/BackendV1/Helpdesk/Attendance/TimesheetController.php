<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\GetTimesheetListLogic;
use App\Attendance\Logics\SummaryTimesheetLogic;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Transformers\TimesheetDetailTransformer;
use App\Attendance\Transformers\TimesheetSummaryTransformer;
use App\Attendance\Traits\AttendanceCheckerUtil;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{

    use AttendanceCheckerUtil;
    public function list(Request $request)
    {
        return GetTimesheetListLogic::getData($request);
    }

    public function detail($timesheetId)
    {
        $attendance = AttendanceTimesheet::find($timesheetId);
        return fractal($attendance, new TimesheetDetailTransformer())->respond(200);
    }

    public function approve(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['timesheetId' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet ID Required';
            return response()->json($response, 200);
        }

        $approveTimesheet = AttendanceTimesheet::find($request->timesheetId);
        if ($approveTimesheet) {
            $approveTimesheet->attendanceApproveId = 1; //APPROVED
            $approveTimesheet->approvedBy = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';
            $approveTimesheet->save();

            $response['isFailed'] = false;
            $response['message'] = 'Timesheet has been approved';
            $response['approvedBy'] = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet not found';
            return response()->json($response, 200);
        }

    }


    public function disapprove(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['timesheetId' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet ID Required';
            return response()->json($response, 200);
        }

        $approveTimesheet = AttendanceTimesheet::find($request->timesheetId);
        if ($approveTimesheet) {
            $approveTimesheet->attendanceApproveId = 98; //DISAPPROVED
            $approveTimesheet->approvedBy = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';
            $approveTimesheet->save();

            $response['isFailed'] = false;
            $response['message'] = 'Timesheet has been disapproved';
            $response['approvedBy'] = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet not found';
            return response()->json($response, 200);
        }

    }

    public function summary(Request $request, $sumType)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['fromDate' => 'required', 'toDate' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'From Date or To Date is missing';
            return response()->json($response, 200);
        }

        return SummaryTimesheetLogic::getData($request, $sumType);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), ['timesheetId' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet ID is required';
            return response()->json($response, 200);
        }

        $timesheet = AttendanceTimesheet::find($request->timesheetId);
        $timesheet->clockInTime = $request->clockInTime;
        $timesheet->clockOutTime = $request->clockOutTime;
        $timesheet->clockInDate = $request->date;
        $timesheet->clockOutDate = $request->date;
        $timesheet->attendanceApproveId = 3; // Edited By Manager

        if ($timesheet->save()) {

            $this->checkValidation($timesheet);
            $response['isFailed'] = false;
            $response['message'] = 'Timesheet has been updated successfully';
            $response['timesheet'] = fractal($timesheet, new TimesheetSummaryTransformer());

            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Timesheet not found';
            return response()->json($response, 200);
        }
    }

}
