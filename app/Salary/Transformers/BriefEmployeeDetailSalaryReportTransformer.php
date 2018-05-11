<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Models\SalaryReport;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class BriefEmployeeDetailSalaryReportTransformer extends TransformerAbstract
{

    use GlobalUtils;
    public function transform(SalaryReport $salaryReport)
    {
        return [
            'id' => $salaryReport->id,
            'employeeName'=>$this->getResultWithNullChecker1Connection($salaryReport,'employee','givenName'),
            'divisionName'=>$this->getResultWithNullChecker3Connection($salaryReport,'employee','employment','division','name'),
            'branchOfficeName'=>$this->getResultWithNullChecker3Connection($salaryReport,'employee','employment','branchOffice','name'),
        ];
    }

}
