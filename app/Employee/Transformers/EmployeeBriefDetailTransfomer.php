<?php

namespace App\Employee\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmployeeBriefDetailTransfomer extends TransformerAbstract
{

    public function transform(MasterEmployee $employee)
    {
        return [
            'id' => $employee->id,
            'employeeNo' => $employee->employeeNo,
            'givenName' => $employee->givenName,
            'surname' => $employee->surname,
            'email' => $employee->email,
            'bankId'=>$employee->bankId,
            'bankName'=>!is_null($employee->bank)?$employee->bank->name:'',
            'bankAccNo'=>$employee->bankAccNo,
            'phoneNo'=>$employee->phoneNo,
            'employeePhoto'=>$employee->employeePhoto,
            'divisionId'=>!is_null($employee->employment)?$employee->employment->divisionId:'',
            'divisionName'=>!is_null($employee->employment)?!is_null($employee->employment->division)?$employee->employment->division->name:'':'',
            'jobPositionId'=>!is_null($employee->employment)?$employee->employment->jobPositionId:'',
            'jobPositionName'=>!is_null($employee->employment)?!is_null($employee->employment->jobPosition)?$employee->employment->jobPosition->name:'':'',
            'branchOfficeId'=>!is_null($employee->employment)?$employee->employment->branchOfficeId:'',
            'branchOfficeName'=>!is_null($employee->employment)?!is_null($employee->employment->branchOffice)?$employee->employment->branchOffice->name:'':''
        ];
    }


}
