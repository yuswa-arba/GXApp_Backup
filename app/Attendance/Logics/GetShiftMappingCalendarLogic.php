<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Transformers\ShiftMappingCalendarTransformer;
use App\Attendance\Transformers\SlotCalendarTransformer;


class GetShiftMappingCalendarLogic extends GetDataUseCase
{

    public function handle($request)
    {
       $dayOffSchedule = DayOffSchedule::whereIn('slotId',$request->slotIds)->get();

       return fractal($dayOffSchedule,new ShiftMappingCalendarTransformer())->respond(200);
    }
}