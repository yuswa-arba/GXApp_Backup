<?php
namespace App\Attendance\Observer;

use App\Attendance\Events\EmployeeClocked;
use App\Attendance\Models\AttendanceTimesheet;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 7/1/18
 * Time: 5:56 PM
 */
class TimesheetObserver
{
    public function created(AttendanceTimesheet $timesheet)
    {

    }

    public function saved(AttendanceTimesheet $timesheet)
    {
        /*Trigger event to update dashboard*/

        // It's clock In
        if ($timesheet->clockInTime != '' && $timesheet->clockInTime != null &&
            ($timesheet->clockOutTime == '' || $timesheet->clockOutTime == null)
        ) {
            broadcast(new EmployeeClocked($timesheet->id, 'in'))->toOthers();
        }

        // It's clock Out
        if ($timesheet->clockOutTime != '' && $timesheet->clockOutTime != null) {
            broadcast(new EmployeeClocked($timesheet->id, 'out'))->toOthers();
        }

    }

    public function updated(AttendanceTimesheet $timesheet)
    {

    }

}