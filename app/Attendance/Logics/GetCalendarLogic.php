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
use App\Traits\GlobalUtils;


class GetCalendarLogic extends GetDataUseCase
{
    use GlobalUtils;
    public function handle($request)
    {

        //get based on current year
        $dayOffSchedule = DayOffSchedule::where('slotId', $request->slotId)->where('date', 'like', '%' . $this->currentYear())->get();
        return fractal($dayOffSchedule, new SlotCalendarTransformer())->respond(200);
    }
}