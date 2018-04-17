<?php

namespace App\Manager\Transformers;

use App\Manager\Models\EditTimesheet;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class EditTimesheetTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(EditTimesheet $editTimesheet)
    {
        return [
            'id'=>$editTimesheet->id,
            'divisionId'=>$editTimesheet->divisionId,
            'divisionName'=>$this->getResultWithNullChecker1Connection($editTimesheet,'division','name'),
            'branchOfficeId'=>$editTimesheet->branchOfficeId,
            'branchOfficeName'=>$this->getResultWithNullChecker1Connection($editTimesheet,'branchOffice','name'),
            'startDate'=>$editTimesheet->startDate,
            'endDate'=>$editTimesheet->endDate,
            'generatedAt'=>$editTimesheet->generatedAt,
            'generatedBy'=>$editTimesheet->generatedBy,
            'dueDate'=>$editTimesheet->dueDate,
            'lastUpdatedAt'=>$editTimesheet->lastUpdatedAt,
            'lastUpdatedBy'=>$editTimesheet->lastUpdatedBy,
            'finishedAt'=>$editTimesheet->finishedAt,
        ];
    }
}
