<?php

namespace App\Http\Controllers\Client\Developer;

use App\Attendance\Events\EmployeeClocked;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.developer.main');
    }

    public function face()
    {
        return view('pages.developer.face');
    }
}
