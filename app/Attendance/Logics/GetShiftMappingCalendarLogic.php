<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\DayOffMappingCalendarTransformer;
use App\Attendance\Transformers\ShiftScheduleMappingCalendarTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Traits\GlobalUtils;


class GetShiftMappingCalendarLogic extends GetShiftCalendarUseCase
{
    use GlobalUtils;

    public function handleDayOffs($request)
    {
        //get based on this current year
        $dayOffSchedule = DayOffSchedule::whereIn('slotId', $request->slotIds)->where('date', 'like', '%' . $this->currentYear())->get();
        return fractal($dayOffSchedule, new DayOffMappingCalendarTransformer())->respond(200);
    }

    public function handleShiftSchedules($request)
    {
        //get based on this current year
        $shiftSchedule = SlotShiftSchedule::whereIn('slotId', $request->slotIds)->where('date', 'like', '%' . $this->currentYear())->get();
        return fractal($shiftSchedule, new ShiftScheduleMappingCalendarTransformer())->respond(200);
    }
}