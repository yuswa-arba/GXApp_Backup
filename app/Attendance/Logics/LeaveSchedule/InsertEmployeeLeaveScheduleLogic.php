<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\LeaveSchedule;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;

class InsertEmployeeLeaveScheduleLogic extends InsertELSUseCase
{
    use GlobalUtils;

    public function handle($request)
    {
        // TODO: Implement handle() method.
    }
}