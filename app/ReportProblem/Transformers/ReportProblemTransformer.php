<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\ReportProblem\Models\ReportProblem;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ReportProblemTransformer extends TransformerAbstract
{
    use GlobalUtils;


    public function transform(ReportProblem $reportProblem)
    {
        return [

            'id'=>$reportProblem->id,
            'from'=>$reportProblem->from,
            'typeId'=>$reportProblem->typeId,
            'typeName'=>$this->getResultWithNullChecker1Connection($reportProblem,'problemType','name'),
            'problem'=>$reportProblem->problem,
            'solution'=>$reportProblem->solution,
            'isSolved'=>$reportProblem->isSolved,

        ];
    }

}
