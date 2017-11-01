<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function __construct()
    {

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
