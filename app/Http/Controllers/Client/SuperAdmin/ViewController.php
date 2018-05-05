<?php

namespace App\Http\Controllers\Client\SuperAdmin;

use App\Components\Models\Bank;
use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\EducationLevel;
use App\Components\Models\JobPosition;
use App\Components\Models\MaritalStatus;
use App\Components\Models\Religion;
use App\Employee\Models\RecruitmentStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class ViewController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        if (Cookie::has('superadmin-logined')) {
            if (Hash::check( env('SUPERADMIN_USER'),Cookie::get('superadmin-logined'))) {
                return view('pages.superAdmin.index');
            } else {
                return view('pages.auth.superAdminLogin');
            }

        } else {
            return view('pages.auth.superAdminLogin');
        }

    }


    public function logout()
    {
        //clear cookies
        Cookie::queue(Cookie::forget('superadmin-logined'));
        return redirect()->route('superadmin.login');
    }


    public function recruitment()
    {
        if (Cookie::has('superadmin-logined')) {
            $educationLevels = EducationLevel::all();
            $religions = Religion::all();
            $maritalStatuses = MaritalStatus::all();
            $jobPositions = JobPosition::all();
            $divisions = Division::all();
            $branchOffices = BranchOffice::all();
            $recruitmentStatuses = RecruitmentStatus::all();
            $banks = Bank::all();

            return view('pages.superAdmin.recruitment', compact(
                    'educationLevels', 'religions', 'maritalStatuses',
                    'jobPositions', 'divisions', 'branchOffices', 'recruitmentStatuses', 'banks')
            );
        } else {
            return view('pages.auth.superAdminLogin');
        }

    }

}
