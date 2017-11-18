<?php

namespace App\Employee\Transformers;

use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Models\RecruitmentStatus;
use League\Fractal\TransformerAbstract;

class EmploymentEditTransfomer extends TransformerAbstract
{

    public function transform(Employment $employment)
    {
        $employee = MasterEmployee::where('id', $employment->employeeId)->first();

        return [
            'employeeId' => $employment->employeeId,
            'employeeNo' => $employee->employeeNo,
            'employeeName' => $employee->givenName,
            'jobPositionId' => $employment->jobPositionId,
            'divisionId' =>  $employment->divisionId,
            'branchOfficeId' =>  $employment->branchOfficeId,
            'recruitmentStatusId' =>  $employment->recruitmentStatusId,
            'dateOfEntry' => $employment->dateOfEntry,
            'dateOfStart' => $employment->dateOfStart,
            'dateOfResignation' => $employment->dateOfResignation,
            'formComponents' => $this->includeFormComponents()

        ];
    }

    public function includeFormComponents()
    {
        $jobPositions = JobPosition::select('id','name')->get();
        $divisions = Division::select('id','name')->get();
        $branchOffices = BranchOffice::select('id','name')->get();
        $recruitmentStatuses = RecruitmentStatus::select('id','name')->get();

        return [
            'jobPositions' => $jobPositions,
            'divisions' => $divisions,
            'branchOffices' => $branchOffices,
            'recruitmentStatuses'=> $recruitmentStatuses
        ];
    }


}
