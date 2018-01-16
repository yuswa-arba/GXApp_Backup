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


    public function __construct()
    {
        $this->middleware(['permission:view attendance']);
    }


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

        if(Auth::user()->hasPermissionTo('generate attendance')){

            $validator = Validator::make($request->all(), ['fromDate' => 'required', 'toDate' => 'required']);

            if ($validator->fails()) {
                $response['isFailed'] = true;
                $response['message'] = 'From Date or To Date is missing';
                return response()->json($response, 200);
            }

            return SummaryTimesheetLogic::getData($request, $sumType);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'You don\'t have permission to generate summary';
            return response()->json($response, 200);

        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), ['timesheetId' => 'required','date'=>'required','clockInTime'=>'required', 'clockOutTime'=>'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required params missing';
            return response()->json($response, 200);
        }

        $timesheet = AttendanceTimesheet::find($request->timesheetId);
        $timesheet->clockInTime = $request->clockInTime;
        $timesheet->clockOutTime = $request->clockOutTime;
        $timesheet->clockInDate = $request->date;
        $timesheet->clockOutDate = $request->date;

        /* if shift id exist. edit it*/
        if($request->shiftId){
            $timesheet->shiftId = $request->shiftId;
        }

        $timesheet->attendanceApproveId = 3; // Edited By Manager
        $timesheet->approvedBy = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';

        if ($timesheet->save()) {

            $this->checkValidationNow($timesheet);

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

    public function createManually(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employeeId' => 'required',
            'clockInTime'=>'required',
            'clockOutTime'=>'required',
            'date'=>'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required params missing';
            return response()->json($response, 200);
        }

        /* Set default shift id */
        $shiftId = 1;// general 8to17
        if($request->shiftId!=''){
            $shiftId = $request->shiftId;
        }

        $create = AttendanceTimesheet::create([
            'employeeId'=>$request->employeeId,
            'shiftId'=>$shiftId,
            'clockInTime'=>$request->clockInTime,
            'clockOutTime'=>$request->clockOutTime,
            'clockInDate'=>$request->date,
            'clockOutDate'=>$request->date,
            'attendanceValidationId'=>98, // Manually Input
            'attendanceApproveId'=>3,// Edited By Manager
            'approvedBy'=>!is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : ''
        ]);

        if($create){
            $response['isFailed'] = false;
            $response['message'] = 'Timesheet has been created successfully';
            $response['timesheet'] = fractal($create, new TimesheetSummaryTransformer());
            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Failed! Unable to create timesheet';
            return response()->json($response, 200);
        }

    }

}
