<?php

namespace App\Salary\Transformers;

use App\Salary\Models\GeneratePayroll;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class GeneratePayrollTransformer extends TransformerAbstract
{

    use GlobalUtils;
    public function transform(GeneratePayroll $generatePayroll)
    {
        return [
            'id' => $generatePayroll->id,
            'fromDate'=>$generatePayroll->fromDate,
            'toDate'=>$generatePayroll->toDate,
            'branchOfficeId'=>$generatePayroll->branchOfficeId,
            'branchOfficeName'=>$this->getResultWithNullChecker1Connection($generatePayroll,'branchOffice','name'),
            'file'=>$generatePayroll->file,
            'generatedDate'=>$generatePayroll->generatedDate,
            'generatedBy'=>$generatePayroll->generatedBy,
            'generatedType'=>$generatePayroll->generatedType,
            'totalEmployee'=>$generatePayroll->totalEmployee,
            'notes'=>$generatePayroll->notes,
            'salaryReportLogId'=>$generatePayroll->salaryReportLogId
        ];
    }

}
