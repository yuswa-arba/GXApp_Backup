<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\SalaryBonusCutType;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class GeneratedSalaryLogsTransformer extends TransformerAbstract
{

    use GlobalUtils;
    public function transform(GenerateSalaryReportLogs $reportLogs)
    {
        return [
            'id' => $reportLogs->id,
            'fromDate' => $reportLogs->fromDate,
            'toDate' => $reportLogs->toDate,
            'branchOfficeId' => $reportLogs->branchOfficeId,
            'branchOfficeName' =>$this->getResultWithNullChecker1Connection($reportLogs,'branchOffice','name'),
            'generatedDate' => $reportLogs->generatedDate,
            'generatedBy'=>$reportLogs->generatedBy,
            'salaryReportIds'=>$reportLogs->salaryReportIds
        ];
    }

}
