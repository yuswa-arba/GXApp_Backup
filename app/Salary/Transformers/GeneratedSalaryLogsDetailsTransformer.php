<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Models\SalaryReport;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class GeneratedSalaryLogsDetailsTransformer extends TransformerAbstract
{

    use GlobalUtils;
    public function transform(SalaryReport $salaryReport)
    {
        return [
            'id' => $salaryReport->id,
            'employeeId'=>$salaryReport->employeeId,
            'employeeName'=>$this->getResultWithNullChecker1Connection($salaryReport,'employee','givenName'),
            'fromDate' => $salaryReport->fromDate,
            'toDate' => $salaryReport->toDate,
            'confirmationStatusId' => $salaryReport->confirmationStatusId,
            'confirmationStatusName'=>$this->getResultWithNullChecker1Connection($salaryReport,'confirmationStatus','name'),
            'confirmationDate'=>$salaryReport->confirmationDate,
            'isPostponed'=>$salaryReport->isPostponed,
            'isSFP'=>$salaryReport->isSubmittedForPayroll
        ];
    }

}
