<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\GetTimesheetListLogic;
use App\Attendance\Models\AttendanceTimesheet;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{

    public function list(Request $request)
    {
        return GetTimesheetListLogic::getData($request);
    }

}
