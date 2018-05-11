<?php

namespace App\Http\Controllers\Client\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function editTimesheet()
    {
        return view('pages.manager.editTimesheet');
    }
}
