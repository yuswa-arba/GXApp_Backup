<?php

namespace App\Employee\Transformers;

use App\Employee\Models\EmployeeSiblings;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmployeeSiblingsTransfomer extends TransformerAbstract
{

    public function transform(EmployeeSiblings $siblings)
    {
        return [
            'id' => $siblings->id,
            'employeeId' => $siblings->employeeId,
            'name' => $siblings->name,
            'address' => $siblings->address,
            'city' => $siblings->city,
            'phoneNumber' => $siblings->phoneNumber
        ];
    }

}
