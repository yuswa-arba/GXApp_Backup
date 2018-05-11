<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Jobs\CheckAttendanceSchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Transformers\AttendanceScheduleTransformer;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view attendance']);
    }

    public function getSchedule()
    {
        $response = array();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['schedule'] = fractal(Shifts::all(),new AttendanceScheduleTransformer());


        return response()->json($response,200);
    }


    public function checkSchedule()
    {
        CheckAttendanceSchedule::dispatch()->onConnection('database')->onQueue('default');
        return response(200);
    }


}
