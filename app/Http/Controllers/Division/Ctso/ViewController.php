<?php

namespace App\Http\Controllers\Division\Ctso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('pages.divisions.ctso');
    }
}
