<?php

namespace App\Employee\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmploymentTransfomer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Employment $employment)
    {
        $employee = MasterEmployee::where('id',$employment->employeeId)->first();
        return [
            'employeeId' =>$employment->id,
            'employeeNo' => $employee->employeeNo,
            'employeeName'=> $employee->givenName,
            'jobPosition' => !is_null($employment->jobPosition)?$employment->jobPosition->name:'',
            'division' => !is_null($employment->division)?$employment->division->name:'',
            'branchOffice' => !is_null($employment->branchOffice)?$employment->branchOffice->name:'',
            'recruitmentStatus' => !is_null($employment->recruitmentStatus)?$employment->recruitmentStatus->name:'',
            'dateOfEntry' => $employment->dateOfEntry,
            'dateOfStart' => $employment->dateOfStart,
            'dateOfResignation' => $employment->dateOfResignation
        ];
    }
}
