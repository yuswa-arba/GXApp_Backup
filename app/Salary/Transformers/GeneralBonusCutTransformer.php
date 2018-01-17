<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\SalaryBonusCutType;
use League\Fractal\TransformerAbstract;

class GeneralBonusCutTransformer extends TransformerAbstract
{

    public function transform(GeneralBonusesCuts $generalBonusesCuts)
    {
        return [
            'id' => $generalBonusesCuts->id,
            'bonusCutTypeId' => $generalBonusesCuts->salaryBonusCutTypeId,
            'bonusCutTypeName' => !is_null($generalBonusesCuts->salaryBonusCutType)?$generalBonusesCuts->salaryBonusCutType->name:'',
            'bonusCutTypeAddOrSub' => !is_null($generalBonusesCuts->salaryBonusCutType)?$generalBonusesCuts->salaryBonusCutType->addOrSub:'',
            'value' => $generalBonusesCuts->value,
            'isActive' => $generalBonusesCuts->isActive,
            'isUsingFormula' => $generalBonusesCuts->isUsingFormula,
            'formula' => $generalBonusesCuts->formula,
            'insertedDate' => $generalBonusesCuts->insertedDate,
            'insertedBy' => $generalBonusesCuts->insertedBy,
            'editing'=>false
        ];
    }

}
