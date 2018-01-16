<?php

namespace App\Http\Controllers\Client\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:view attendance']);
    }

    public function dashboard()
    {
        return view('pages.attendance.dashboard');
    }

    public function slot()
    {
        return view('pages.attendance.slot');
    }

    public function schedule()
    {
        return view('pages.attendance.schedule');
    }


    public function setting()
    {
        return view('pages.attendance.setting');
    }

    public function timesheet()
    {
        return view('pages.attendance.timesheet');
    }

}
