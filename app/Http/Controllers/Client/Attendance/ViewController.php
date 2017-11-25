<?php

namespace App\Http\Controllers\Client\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function dashboard()
    {
        return view('pages.attendance.dashboard');
    }

    public function setting()
    {
        return view('pages.attendance.setting');
    }
    
}
