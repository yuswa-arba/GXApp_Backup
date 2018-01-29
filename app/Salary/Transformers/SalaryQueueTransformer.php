<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Models\SalaryQueue;
use App\Salary\Models\SalaryReport;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class SalaryQueueTransformer extends TransformerAbstract
{

    use GlobalUtils;
    public function transform(SalaryQueue $salaryQueue)
    {
        return [
            'id' => $salaryQueue->id,
            'employeeId' => $salaryQueue->employeeId,
            'employeeName'=>$this->getResultWithNullChecker1Connection($salaryQueue,'employee','givenName').' '. $this->getResultWithNullChecker1Connection($salaryQueue,'employee','surname'),
            'divisionId'=>$this->getResultWithNullChecker2Connection($salaryQueue,'employee','employment','divisionId'),
            'divisionName'=>$this->getResultWithNullChecker3Connection($salaryQueue,'employee','employment','division','name'),
            'branchOfficeId'=>$this->getResultWithNullChecker2Connection($salaryQueue,'employee','employment','branchOfficeId'),
            'branchOfficeName'=>$this->getResultWithNullChecker3Connection($salaryQueue,'employee','employment','branchOffice','name'),
            'salaryBonusCutTypeId'=>$salaryQueue->salaryBonusCutTypeId,
            'salaryBonusCutTypeName'=>$this->getResultWithNullChecker1Connection($salaryQueue,'salaryBonusCutType','name'),
            'salaryBonusCutTypeAddOrSub'=>$this->getResultWithNullChecker1Connection($salaryQueue,'salaryBonusCutType','addOrSub'),
            'value'=>$salaryQueue->value,
            'notes'=>$salaryQueue->notes,
            'insertedDate'=>$salaryQueue->insertedDate,
            'insertedBy'=>$salaryQueue->insertedBy
        ];
    }

}
