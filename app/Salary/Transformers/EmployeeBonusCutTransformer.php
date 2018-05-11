<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\SalaryBonusCutType;
use League\Fractal\TransformerAbstract;

class EmployeeBonusCutTransformer extends TransformerAbstract
{

    public function transform(EmployeeBonusesCuts $employeeBonusesCuts)
    {
        return [
            'id' => $employeeBonusesCuts->id,
            'employeeId'=>$employeeBonusesCuts->employeeId,
            'bonusCutTypeId' => $employeeBonusesCuts->salaryBonusCutTypeId,
            'bonusCutTypeName' => !is_null($employeeBonusesCuts->salaryBonusCutType)?$employeeBonusesCuts->salaryBonusCutType->name:'',
            'bonusCutTypeAddOrSub' => !is_null($employeeBonusesCuts->salaryBonusCutType)?$employeeBonusesCuts->salaryBonusCutType->addOrSub:'',
            'value' => $employeeBonusesCuts->value,
            'isActive' => $employeeBonusesCuts->isActive,
            'isUsingFormula' => $employeeBonusesCuts->isUsingFormula,
            'formula' => $employeeBonusesCuts->formula,
            'insertedDate' => $employeeBonusesCuts->insertedDate,
            'insertedBy' => $employeeBonusesCuts->insertedBy,
            'editing'=>false
        ];
    }

}
