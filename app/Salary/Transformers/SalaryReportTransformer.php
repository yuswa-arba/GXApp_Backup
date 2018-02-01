<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryUtils;
use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Crypt;
use League\Fractal\TransformerAbstract;

class SalaryReportTransformer extends TransformerAbstract
{

    use GlobalUtils;
    use SalaryUtils;

    public function transform(SalaryReport $salaryReport)
    {
        return [
            'id' => $salaryReport->id,
            'employeeId' => $salaryReport->employeeId,
            'employeeName'=>$this->getResultWithNullChecker1Connection($salaryReport,'employee','givenName'),
            'divisionId'=>$this->getResultWithNullChecker2Connection($salaryReport,'employee','employment','divisionId'),
            'divisionName'=>$this->getResultWithNullChecker3Connection($salaryReport,'employee','employment','division','name'),
            'branchOfficeId'=>$this->getResultWithNullChecker2Connection($salaryReport,'employee','employment','branchOfficeId'),
            'branchOfficeName'=>$this->getResultWithNullChecker3Connection($salaryReport,'employee','employment','branchOffice','name'),
            'basicSalary'=>$this->getEmployeeBasicSalary($salaryReport->basicSalary),
            'totalSalaryBonus'=>$this->formatRupiahCurrency($salaryReport->totalSalaryBonus),
            'totalSalaryCut'=>$this->formatRupiahCurrency($salaryReport->totalSalaryCut),
            'salaryReceived'=>$this->formatRupiahCurrency($salaryReport->salaryReceived),
            'confirmationStatusId'=>$salaryReport->confirmationStatusId,
            'confirmationStatusName'=>$this->getResultWithNullChecker1Connection($salaryReport,'confirmationStatus','name'),
            'confirmationDate'=>$salaryReport->confirmationDate,
            'isPostponed'=>$salaryReport->isPostponed,
            'isSubmittedForPayroll'=>$salaryReport->isSubmittedForPayroll
        ];
    }

}
