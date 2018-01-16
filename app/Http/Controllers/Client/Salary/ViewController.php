<?php

namespace App\Http\Controllers\Client\Salary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:access salary']);
    }

    public function report()
    {
        return view('pages.salary.report');
    }

    public function setting()
    {
        return view('pages.salary.setting');
    }
}
