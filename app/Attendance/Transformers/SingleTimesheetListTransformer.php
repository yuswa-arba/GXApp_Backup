<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class SingleTimesheetListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(AttendanceTimesheet $timesheet)
    {
        return [
            'id' => $timesheet->id,
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
            'clockOutPhoto' => $timesheet->employeePhotoClockOut
        ];
    }
}
