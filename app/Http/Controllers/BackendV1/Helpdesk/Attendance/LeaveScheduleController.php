<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;


use App\Attendance\Logics\LeaveSchedule\GetLeaveScheduleListLogic;
use App\Attendance\Logics\LeaveSchedule\InsertEmployeeLeaveScheduleLogic;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveScheduleController extends Controller
{


    public function __construct()
    {
        $this->middleware(['permission:view attendance']);
    }

    public function list(Request $request)
    {
        return GetLeaveScheduleListLogic::getData($request);
    }

    /*
     * @for Employee
     * @desc change dates / description / leave type
     * */
    public function update(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'elsId' => 'required'
        ]);

        if ($validator->fails) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';

            return response()->json($response, 200);
        }

        //is valid

        //TODO: update ELS logic

    }

    /*
     * @for employee
     * @desc remove leave schedule
     * */
    public function delete(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'elsId' => 'required'
        ]);

        if ($validator->fails) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';

            return response()->json($response, 200);
        }

        //is valid

        //TODO: delete ELS logic

    }

    /*
     * @for Manager / Admin
     * @desc same with update but its from Manager and may add notes, update approval id
     * */
    public function answer(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'elsId' => 'required',
            'answer'=>'required'
        ]);

        if ($validator->fails) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';

            return response()->json($response, 200);
        }

        //is valid

        //TODO: asnwer ELS logic
    }


}
