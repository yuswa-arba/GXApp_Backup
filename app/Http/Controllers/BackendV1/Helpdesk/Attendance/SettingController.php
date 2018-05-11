<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Models\AttendanceSetting;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Transformers\LiveClockInFeedTransformer;
use App\Attendance\Transformers\LiveClockOutFeedTransformer;
use App\Components\Transformers\BasicSettingTrasnformer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view attendance']);
    }

    public function list()
    {
        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['attendanceSettings'] = fractal(AttendanceSetting::all(), new BasicSettingTrasnformer());

        return response()->json($response, 200);
    }

    public function edit(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';
            return response()->json($response, 200);
        }

        //is valid

        $update = AttendanceSetting::where('id',$request->id)->update(['value'=>$request->value,'description'=>$request->description]);

        if($update){

            $response['isFailed'] = false;
            $response['message'] = 'Attendance setting has been updated successfully';
            $response['attendanceSetting'] = fractal(AttendanceSetting::find($request->id),new BasicSettingTrasnformer());
            return response()->json($response,200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find update attendance setting';
            return response()->json($response, 200);
        }
    }


}
