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

class TimesheetSummaryTransformer extends TransformerAbstract
{
    use GlobalUtils;


    public function transform(AttendanceTimesheet $timesheet)
    {
        return [
            'id' => $timesheet->id,
            'shiftId' => $timesheet->shiftId,
            'shiftName' => !is_null($timesheet->shift) ? $timesheet->shift->name : '',
            'clockInDate' => $timesheet->clockInDate,
            'clockInTime' => $timesheet->clockInTime,
            'clockOutDate' => $timesheet->clockOutDate,
            'clockOutTime' => $timesheet->clockOutTime,
            'workHour' => $this->countWorkHour($timesheet),
            'minutesCheckInLate' => $this->countMinutesCheckInLate($timesheet),
            'minutesCheckOutEarly' => $this->countMinutesChcekOutEarly($timesheet),
            'minutesCheckOutLate' => $this->countMinutesCheckOutLate($timesheet),
            'attendanceApproveId' => $timesheet->attendanceApproveId,
            'attendanceApproveName' => !is_null($timesheet->attendanceApproval) ? $timesheet->attendanceApproval->name : '',
            'attendanceValidationId' => $timesheet->attendanceValidationId,
            'attendanceValidationName' => !is_null($timesheet->attendanceValidation) ? $timesheet->attendanceValidation->name : '',
        ];
    }

    private function countWorkHour($timesheet)
    {
        if ($timesheet->clockInTime != '' && $timesheet->clockOutTime != '') {
            $clockInTime = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockInDate . ' ' . $timesheet->clockInTime);
            $clockOutTime = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockOutDate . ' ' . $timesheet->clockOutTime);

            return $clockOutTime->diffInHours($clockInTime);
        }

        return 0;

    }

    private function countMinutesCheckInLate($timesheet)
    {

        if ($timesheet->clockInDate != '' && $timesheet->clockInTime != '') {
            $clockInTime = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockInDate . ' ' . $timesheet->clockInTime);
            $shift = Shifts::find($timesheet->shiftId);
            $shiftWorkStartAt = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockInDate . ' ' . $shift->workStartAt);

            // if its late then return minutes late
            if ($clockInTime->gt($shiftWorkStartAt)) {
                return $clockInTime->diffInMinutes($shiftWorkStartAt);
            }
        }


        return 0;
    }


    private function countMinutesChcekOutEarly($timesheet)
    {
        if ($timesheet->clockOutDate != '' && $timesheet->clockOutTime != '') {
            $clockOutTime = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockOutDate . ' ' . $timesheet->clockOutTime);
            $shift = Shifts::find($timesheet->shiftId);
            $shiftWorkEndAt = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockOutDate . ' ' . $shift->workEndAt);

            // if its early then return minutes early
            if ($clockOutTime->lt($shiftWorkEndAt)) {
                return $clockOutTime->diffInMinutes($shiftWorkEndAt);
            }
        }

        return 0;
    }

    private function countMinutesCheckOutLate($timesheet)
    {
        if ($timesheet->clockOutDate != '' && $timesheet->clockOutTime != '') {
            $clockOutTime = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockOutDate . ' ' . $timesheet->clockOutTime);
            $shift = Shifts::find($timesheet->shiftId);
            $shiftWorkEndAt = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockOutDate . ' ' . $shift->workEndAt);

            // if its early then return minutes early
            if ($clockOutTime->gt($shiftWorkEndAt)) {
                return $clockOutTime->diffInMinutes($shiftWorkEndAt);
            }
        }

        return 0;
    }


}
