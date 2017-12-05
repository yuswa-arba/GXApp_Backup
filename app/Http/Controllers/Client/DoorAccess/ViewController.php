<?php

namespace App\Http\Controllers\Client\DoorAccess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function list()
    {
        return view('pages.doorAccess.list');
    }

    public function control()
    {
        return view('pages.doorAccess.control');
    }
}
