<?php

namespace App\Http\Controllers\Client\Settings\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function index()
    {
        return view('pages.passport.main');
    }
}
