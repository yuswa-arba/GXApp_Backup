<?php

namespace App\Http\Controllers\Client\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        return view('pages.employee.list');
    }

    public function recruitment()
    {
        return view('pages.employee.recruitment');
    }
}
