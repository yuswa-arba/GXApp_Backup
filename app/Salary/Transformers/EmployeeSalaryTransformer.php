<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Models\EmployeeSalary;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\SalaryBonusCutType;
use League\Fractal\TransformerAbstract;

class EmployeeSalaryTransformer extends TransformerAbstract
{

    public function transform(EmployeeSalary $employeeSalary)
    {
        return [
            'id' => $employeeSalary->id,
            'employeeId'=>$employeeSalary->employeeId,
            'basicSalary'=>$employeeSalary->basicSalary,
            'insertedDate'=>$employeeSalary->insertedDate,
            'insertedBy'=>$employeeSalary->insertedBy,
        ];
    }

}
