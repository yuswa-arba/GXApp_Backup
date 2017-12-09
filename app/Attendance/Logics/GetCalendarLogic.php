<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Transformers\SlotCalendarTransformer;


class GetCalendarLogic extends GetDataUseCase
{

    public function handle($request)
    {
       $dayOffSchedule = DayOffSchedule::where('slotId',$request->slotId)->get();

       return fractal($dayOffSchedule,new SlotCalendarTransformer())->respond(200);
    }
}