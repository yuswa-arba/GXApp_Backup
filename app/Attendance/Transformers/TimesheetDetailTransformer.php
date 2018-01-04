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

class TimesheetDetailTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(AttendanceTimesheet $timesheet)
    {
        return [
            'id' => $timesheet->id,
            'employeeId' => $timesheet->employeeId,
            'employeeName' => !is_null($timesheet->employee) ? $timesheet->employee->givenName . ' ' . $timesheet->employee->surname : '',
            'divisionName' => !is_null($timesheet->employee->employment->division) ? $timesheet->employee->employment->division->name : '',
            'shiftId' => $timesheet->shiftId,
            'shiftName' => !is_null($timesheet->shift) ? $timesheet->shift->name : '',
            'shiftWorkStartAt' => !is_null($timesheet->shift) ? $timesheet->shift->workStartAt : '',
            'shiftWorkEndAt' => !is_null($timesheet->shift) ? $timesheet->shift->workEndAt : '',
            'attendanceApproveId' => $timesheet->attendanceApproveId,
            'attendanceApproveName' => !is_null($timesheet->attendanceApproval) ? $timesheet->attendanceApproval->name : '',
            'approvedBy' => $timesheet->approvedBy,
            'attendanceValidationId' => $timesheet->attendanceValidationId,
            'attendanceValidationName' => !is_null($timesheet->attendanceValidation) ? $timesheet->attendanceValidation->name : '',
            'clockInTime' => $timesheet->clockInTime,
            'clockInDate' => $timesheet->clockInDate,
            'clockInPhoto' => $timesheet->employeePhotoClockIn,
            'clockOutTime' => $timesheet->clockOutTime,
            'clockOutDate' => $timesheet->clockOutDate,
            'clockOutPhoto' => $timesheet->employeePhotoClockOut,
            'clockInViaType' => $this->clockingVia($timesheet->clockInViaTypeId),
            'clockOutViaType' => $this->clockingVia($timesheet->clockOutViaTypeId),
            'clockInKiosk' => !is_null($timesheet->clockInKiosk) ? $timesheet->clockInKiosk->codeName : '',
            'clockOutKiosk' => !is_null($timesheet->clockOutKiosk) ? $timesheet->clockOutKiosk->codeName : '',
            'clockInIpAddress'=>$timesheet->clockInInAddress,
            'clockOutIpAddress'=>$timesheet->clockOutIpAddress,
            'clockInBrowser'=>$timesheet->clockInBrowser,
            'clockOutBrowser'=>$timesheet->clockOutBrowser
        ];
    }


}
