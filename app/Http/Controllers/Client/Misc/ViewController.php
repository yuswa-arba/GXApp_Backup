<?php

namespace App\Http\Controllers\Client\Misc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.misc.index');
    }

    public function notification()
    {
        return view('pages.misc.notification');
    }
}
