<?php

namespace App\Http\Controllers\Division\HouseHold;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('pages.divisions.household');
    }
}
