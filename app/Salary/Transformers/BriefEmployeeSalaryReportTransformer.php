<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryUtils;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class BriefEmployeeSalaryReportTransformer extends TransformerAbstract
{

    use GlobalUtils;
    use SalaryUtils;
    public function transform(SalaryReport $salaryReport)
    {
        return [
            'id' => $salaryReport->id,
            'date'=>$salaryReport->fromDate.' - '.$salaryReport->toDate,
            'salaryReceived'=>$this->formatRupiahCurrency($salaryReport->salaryReceived),
            'confirmationStatusId'=>$salaryReport->confirmationStatusId,
            'confirmationStatusName'=>$this->getResultWithNullChecker1Connection($salaryReport,'confirmationStatus','name'),
            'isPostponed'=>$salaryReport->isPostponed
        ];
    }

}
