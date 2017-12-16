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
use App\Attendance\Transformers\DayOffCalendarTransformer;
use App\Attendance\Transformers\ShiftScheduleCalendarTransformer;
use App\Attendance\Transformers\SlotCalendarTransformer;


class GetShiftMappingCalendarLogic extends GetShiftCalendarUseCase
{
    public function handleDayOffs($request)
    {
        $dayOffSchedule = DayOffSchedule::whereIn('slotId',$request->slotIds)->get();
        return fractal($dayOffSchedule,new DayOffCalendarTransformer())->respond(200);
    }

    public function handleShiftSchedules($request)
    {
        $shiftSchedule = SlotShiftSchedule::whereIn('slotId',$request->slotIds)->get();
        return fractal($shiftSchedule,new ShiftScheduleCalendarTransformer())->respond(200);
    }
}