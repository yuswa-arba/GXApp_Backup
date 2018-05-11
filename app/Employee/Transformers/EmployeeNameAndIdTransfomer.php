<?php

namespace App\Employee\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmployeeNameAndIdTransfomer extends TransformerAbstract
{

    public function transform(MasterEmployee $employee)
    {
        return [
            'id' => $employee->id,
            'employeeNo' => $employee->employeeNo,
            'givenName' => $employee->givenName,
            'surname' => $employee->surname,
        ];
    }


}
