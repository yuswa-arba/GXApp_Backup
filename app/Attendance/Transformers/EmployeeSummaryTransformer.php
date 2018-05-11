<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class EmployeeSummaryTransformer extends TransformerAbstract
{
    public function transform(MasterEmployee $employee)
    {
        return [
            'id' => $employee->id,
            'employeeNo' => $employee->employeeNo,
            'employeeName' => $employee->givenName . ' ' . $employee->surname,
            'divisionName' => !is_null($employee->employment)?!is_null($employee->employment->division) ? $employee->employment->division->name : '':'',
            'branchOfficeName' => !is_null($employee->employment)?!is_null($employee->employment->branchOffice) ? $employee->employment->branchOffice->name : '':''
        ];
    }

}
