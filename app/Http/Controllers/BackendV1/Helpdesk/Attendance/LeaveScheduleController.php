<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;


use App\Attendance\Logics\LeaveSchedule\GetLeaveScheduleListLogic;
use App\Attendance\Models\AttendanceSetting;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\Controller;
use App\Traits\GlobalConfig;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeaveScheduleController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware(['permission:view attendance']);
    }

    public function list(Request $request)
    {
        return GetLeaveScheduleListLogic::getData($request);
    }

    /*
     * @for Manager / Admin
     * @desc same with update but its from Manager and may add notes, update approval id
     * */
    public function answer(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'elsIds' => 'required',
            'leaveApprovalId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';

            return response()->json($response, 200);
        }

        //is valid

        foreach ($request->elsIds as $elsId) {

            $leaveSchedule = EmployeeLeaveSchedule::find($elsId);

            if ($leaveSchedule) {

                // Make sure requested leave date is greater than today
                if (Carbon::createFromFormat('d/m/Y', $leaveSchedule->fromDate)->gt(Carbon::now())) {

                    Log::info(EmployeeLeaveSchedule::where('employeeId', $leaveSchedule->employeeId)
                        ->where('year', $leaveSchedule->year)// year
                        ->where('leaveApprovalId', ConfigCodes::$LEAVE_APPROVAL['APPROVED'])
                        ->sum('totalDays'));

                    //Make sure the employee has not reached the maximum leave limit
                    if (EmployeeLeaveSchedule::where('employeeId', $leaveSchedule->employeeId)
                            ->where('year', $leaveSchedule->year)// year
                            ->where('leaveApprovalId', ConfigCodes::$LEAVE_APPROVAL['APPROVED'])
                            ->sum('totalDays') < AttendanceSetting::where('name','max-leave-days')->first()['value']
                    ) {
                        $leaveSchedule->leaveApprovalId = $request->leaveApprovalId;
                        $leaveSchedule->answer = $request->answer;
                        $leaveSchedule->answeredBy = $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName');
                        $leaveSchedule->save();
                    }

                }

            }
        }

        /* return success response */
        $response['isFailed'] = false;
        $response['message'] = 'Success';

        return response()->json($response, 200);

    }


}
