<?php

namespace App\Employee\Transformers;

use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmployeeListTransfomer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(MasterEmployee $employee)
    {
        return [
            'id' => $employee->id,
            'employeeNo'=>$employee->employeeNo,
            'surname' => $employee->surname,
            'givenName' => $employee->givenName,
            'nickName' => $employee->nickName,
            'employeePhoto' =>$employee->employeePhoto,
            'branchOffice' => !is_null($employee->employment)?!is_null($employee->employment->branchOffice) ? $employee->employment->branchOffice->name : '':'',
            'division' => !is_null($employee->employment)?!is_null($employee->employment->division) ? $employee->employment->division->name : '':'',
            'jobPosition' => !is_null($employee->employment)?!is_null($employee->employment->jobPosition) ? $employee->employment->jobPosition->name : '':'',
        ];
    }
}
