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

class LiveClockOutFeedTransformer extends TransformerAbstract
{
    use GlobalUtils;


    public function transform(AttendanceTimesheet $timesheet)
    {
        return [
            'id' => $timesheet->id,
            'employeeName' => !is_null($timesheet->employee) ? $timesheet->employee->givenName . ' ' . $timesheet->employee->surname : '',
            'divisionName' => !is_null($timesheet->employee->employment->division) ? $timesheet->employee->employment->division->name : '',
            'shiftName' => !is_null($timesheet->shift) ? $timesheet->shift->name : '',
            'time' => $timesheet->clockOutTime,
            'date' => $timesheet->clockOutDate,
            'via' => $this->getClockOutVia($timesheet->clockOutViaTypeId),
            'viaDesc' => $this->getClockOutViaDesc($timesheet),
            'photo'=>$timesheet->employeePhotoClockOut
        ];
    }

    private function getClockOutVia($clockInViaTypeId)
    {
        switch ($clockInViaTypeId) {
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK']:
                return "Kiosk";
                break;
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_PERSONAL_DEVICE']:
                return "Personal App";
                break;
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_WEB_PORTAL']:
                return "Web Portal";
                break;
            default:
                return "";
                break;
        }
    }

    private function getClockOutViaDesc($timesheet)
    {
        switch ($timesheet->clockInViaTypeId) {
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK']:
                return !is_null($timesheet->clockOutKiosk) ? $timesheet->clockOutKiosk->codeName : '';
                break;
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_PERSONAL_DEVICE']:
                return "";
                break;
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_WEB_PORTAL']:
                return "Browser: " . $timesheet->clockOutBrowser . '(' . $timesheet->clockOutIpAddress . ')';
                break;
            default:
                break;
        }
    }


}
