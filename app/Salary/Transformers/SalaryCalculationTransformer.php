<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Models\SalaryCalculation;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryUtils;
use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Crypt;
use League\Fractal\TransformerAbstract;

class SalaryCalculationTransformer extends TransformerAbstract
{

    use GlobalUtils;
    use SalaryUtils;

    public function transform(SalaryCalculation $salaryCalculation)
    {
        return [
            'id' => $salaryCalculation->id,
            'salaryReportId' => $salaryCalculation->salaryReportId,
            'salaryBonusCutTypeId' => $salaryCalculation->salaryBonusCutTypeId,
            'salaryBonusCutTypeName' => $this->getResultWithNullChecker1Connection($salaryCalculation, 'salaryBonusCutType', 'name'),
            'salaryBonusCutTypeAddOrSub' => $this->getResultWithNullChecker1Connection($salaryCalculation, 'salaryBonusCutType', 'addOrSub'),
            'value' => $this->formatRupiahCurrency($salaryCalculation->value),
            'isProcessed' => $salaryCalculation->isProcessed,
            'processedDate' => $salaryCalculation->processedDate,
            'isEdited' => $salaryCalculation->isEdited,
            'editedBy' => $salaryCalculation->editedBy,
            'editedDate' => $salaryCalculation->editedDate,
            'isDeleted' => $salaryCalculation->isDeleted,
            'deletedDate' => $salaryCalculation->deletedDate,
            'deletedBy' => $salaryCalculation->deletedBy,
            'notes' => $salaryCalculation->notes
        ];
    }

}
