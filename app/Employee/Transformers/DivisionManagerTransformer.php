<?php

namespace App\Employee\Transformers;

use App\Components\Models\DivisionManager;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Models\Resignation;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class DivisionManagerTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(DivisionManager $divisionManager)
    {
        return [
            'id' => $divisionManager->id,
            'employeeId' => $divisionManager->employeeId,
            'employeeNo' => !is_null($divisionManager->employee) ? $divisionManager->employee->employeeNo : '',
            'employeeName' => $this->getResultWithNullChecker1Connection($divisionManager, 'employee', 'givenName') . ' ' . $this->getResultWithNullChecker1Connection($divisionManager, 'employee', 'surname'),
            'divisionId' => $divisionManager->divisionId,
            'divisionName' => $this->getResultWithNullChecker1Connection($divisionManager, 'division', 'name'),
            'branchOfficeId' => $divisionManager->branchOfficeId,
            'branchOfficeName' => $this->getResultWithNullChecker1Connection($divisionManager, 'branchOffice', 'name'),
            'isActive' => $divisionManager->isActive,
            'startDate' => $divisionManager->startDate,
            'endDate' => $divisionManager->endDate,
            'editing' => false
        ];
    }
}
