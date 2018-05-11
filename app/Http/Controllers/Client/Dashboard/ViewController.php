<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.dashboard.home');
    }
}
