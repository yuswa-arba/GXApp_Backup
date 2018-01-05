<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\GetTimesheetListLogic;
use App\Attendance\Logics\SummaryTimesheetLogic;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Transformers\LiveClockInFeedTransformer;
use App\Attendance\Transformers\LiveClockOutFeedTransformer;
use App\Attendance\Transformers\LiveFeedTransformer;
use App\Attendance\Transformers\TimesheetDetailTransformer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function livefeed()
    {
        $timesheetIn = AttendanceTimesheet::where('clockInDate',Carbon::now()->format('d/m/Y'))->where('clockInTime','!=','')->orderBy('clockInTime','desc')->get();
        $timesheetOut = AttendanceTimesheet::where('clockOutDate',Carbon::now()->format('d/m/Y'))->where('clockOutTime','!=','')->orderBy('clockOutTime','desc')->get();

        $response = array();
        $response['in'] = fractal($timesheetIn,new LiveClockInFeedTransformer());
        $response['out'] = fractal($timesheetOut,new LiveClockOutFeedTransformer());

        return response()->json($response,200);
    }

}
