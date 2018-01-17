<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\SalaryBonusCutType;
use League\Fractal\TransformerAbstract;

class SalaryBonusCutTransformer extends TransformerAbstract
{

    public function transform(SalaryBonusCutType $bonusCutType)
    {
        return [
            'id' => $bonusCutType->id,
            'name' => $bonusCutType->name,
            'addOrSub' => $bonusCutType->addOrSub,
            'isRelatedToDivision' => $bonusCutType->isRelatedToDivision,
            'divisionId' => $bonusCutType->divisionId,
            'divisionName' => !is_null($bonusCutType->divison) ? $bonusCutType->divison->name : '',
            'editing'=>false
        ];
    }

}
