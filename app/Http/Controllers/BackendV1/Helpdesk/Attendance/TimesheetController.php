<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\AttendanceLogic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function clockIn(Request $request)
    {
        return AttendanceLogic::clock($request);
    }

    public function clockOut(Request $request)
    {
        return AttendanceLogic::clock($request);
    }
}
