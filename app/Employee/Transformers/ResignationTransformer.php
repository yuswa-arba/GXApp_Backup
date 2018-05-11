<?php

namespace App\Employee\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Models\Resignation;
use League\Fractal\TransformerAbstract;

class ResignationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Resignation $resignation)
    {

        return [
            'employeeId' =>$resignation->employeeId,
            'employeeNo' => !is_null($resignation->employee)?$resignation->employee->employeeNo:'',
            'employeeName'=> !is_null($resignation->employee)?$resignation->employee->givenName:'' . ' '. !is_null($resignation->employee)?$resignation->employee->surnmae:'',
            'submissionDate'=>$resignation->submissionDate,
            'effectiveDate'=>$resignation->effectiveDate,
            'resignationLetter'=>$resignation->resignationLetter,
            'professionalism'=>$resignation->professionalism,
            'reason'=>$resignation->reason,
            'notes'=>$resignation->notes,
            'submittedBy'=>$resignation->submittedBy,
        ];
    }
}
