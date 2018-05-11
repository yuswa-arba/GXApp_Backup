<?php

namespace App\Employee\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class FaceAPIDetailTransfomer extends TransformerAbstract
{

    public function transform(MasterEmployee $employee)
    {
        return [
            'employeeId' => $employee->id,
            'employeeNo' => $employee->employeeNo,
            'employeeFullName'=> $employee->givenName . ' '. $employee->surname,
            'personId' => !is_null($employee->facePerson) ? $employee->facePerson->personId : '-',
            'personGroupId' => !is_null($employee->facePerson) ? $employee->facePerson->personGroupId : '-',
        ];
    }

}
