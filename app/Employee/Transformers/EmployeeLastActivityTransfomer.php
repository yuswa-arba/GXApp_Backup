<?php

namespace App\Employee\Transformers;

use App\Attendance\Models\AttendanceTimesheet;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use League\Fractal\TransformerAbstract;

class EmployeeLastActivityTransfomer extends TransformerAbstract
{


    public function transform(MasterEmployee $employee)
    {
        return [
            'id' => $employee->id,
            'employeeNo' => $employee->employeeNo,
            'givenName' => $employee->givenName,
            'surname' => $employee->surname,
            'lastActivity' => $this->getEmployeeLastActivity($employee->id),

        ];
    }

    private function getEmployeeLastActivity($employeeId)
    {

        $latestTimeSheetRecord = AttendanceTimesheet::where('employeeId', $employeeId)->latest()->first();

        /* Logic */
        $clockedIn = ($latestTimeSheetRecord->clockInDate != '' && $latestTimeSheetRecord->clockInTime != ''
            && $latestTimeSheetRecord->clockOutDate == '' && $latestTimeSheetRecord->clockOutTime == '');

        $clockedOut = ($latestTimeSheetRecord->clockInDate != '' && $latestTimeSheetRecord->clockInTime != ''
            && $latestTimeSheetRecord->clockOutDate != '' && $latestTimeSheetRecord->clockOutTime != '');

        /* Last activity type*/
        $type = ConfigCodes::$LAST_ACTIVITY_TYPE['UNDEFINED'];
        if ($clockedOut) {
            $type = ConfigCodes::$LAST_ACTIVITY_TYPE['CLOCKED_OUT'];
        } else if ($clockedIn) {
            $type = ConfigCodes::$LAST_ACTIVITY_TYPE['CLOCKED_IN'];
        }

        /* Last activity time*/
        $time = '';
        if ($type == ConfigCodes::$LAST_ACTIVITY_TYPE['CLOCKED_IN']) {
            $time = $latestTimeSheetRecord->clockInDate . ' at ' . $latestTimeSheetRecord->clockInTime;
        } else if ($type == ConfigCodes::$LAST_ACTIVITY_TYPE['CLOCKED_OUT']) {
            $time = $latestTimeSheetRecord->clockOutDate . ' at ' . $latestTimeSheetRecord->clockOutTime;

        }

        return ['type' => $type, 'time' => $time];

    }

}
