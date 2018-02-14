<?php

namespace App\Http\Controllers\Client\Developer;

use App\Http\Controllers\Controller;


class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:developer']);
    }

    public function index()
    {
        return view('pages.developer.main');
    }

    public function face()
    {
        return view('pages.developer.face');
    }

    public function logs()
    {
        return view('pages.developer.logs');
    }

    public function test()
    {
        return view('pages.developer.test');
    }
}
