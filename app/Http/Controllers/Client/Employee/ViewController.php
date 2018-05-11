<?php

namespace App\Http\Controllers\Client\Employee;

use App\Components\Models\Bank;
use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\EducationLevel;
use App\Components\Models\JobPosition;
use App\Components\Models\MaritalStatus;
use App\Components\Models\Religion;
use App\Employee\Models\EmployeeStatus;
use App\Employee\Models\RecruitmentStatus;
use App\Http\Controllers\BackendV1\Helpdesk\Employee\RecruitmentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:view employee']);
    }

    public function index()
    {
        return view('pages.employee.list');
    }

    public function managers()
    {
        return view('pages.employee.managers');
    }

    public function recruitment()
    {
        $educationLevels = EducationLevel::all();
        $religions = Religion::all();
        $maritalStatuses = MaritalStatus::all();
        $jobPositions = JobPosition::all();
        $divisions = Division::all();
        $branchOffices = BranchOffice::all();
        $recruitmentStatuses = RecruitmentStatus::all();
        $banks = Bank::all();

        return view('pages.employee.recruitment', compact(
            'educationLevels', 'religions', 'maritalStatuses',
            'jobPositions', 'divisions','branchOffices', 'recruitmentStatuses','banks')
        );
    }

    public function resignation()
    {
        return view('pages.employee.resignation');
    }

}
