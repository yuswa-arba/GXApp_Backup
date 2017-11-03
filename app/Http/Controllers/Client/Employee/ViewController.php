<?php

namespace App\Http\Controllers\Client\Employee;

use App\Components\Models\EducationLevel;
use App\Components\Models\MaritalStatus;
use App\Components\Models\Religion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth.admin');
//    }

    public function index()
    {

        return view('pages.employee.list');
    }

    public function recruitment()
    {
        $educationLevels = EducationLevel::all();
        $religions = Religion::all();
        $maritalStatuses = MaritalStatus::all();

        return view('pages.employee.recruitment', compact('educationLevels', 'religions', 'maritalStatuses'));
    }


}
