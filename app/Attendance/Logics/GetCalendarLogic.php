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
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Traits\GlobalUtils;


class GetCalendarLogic extends GetDataUseCase
{
    use GlobalUtils;
    public function handle($request)
    {

        $response = array();

        //get based on current year
        $dayOffSchedule = DayOffSchedule::where('slotId', $request->slotId)->where('date', 'like', '%' . $this->currentYear())->get();
        $shiftSchedule = SlotShiftSchedule::where('slotId', $request->slotId)->where('date', 'like', '%' . $this->currentYear())->get();

        $response['dayOffs'] = fractal($dayOffSchedule, new DayOffSingleCalendarTransformer());
        $response['shiftSchedules'] = fractal($shiftSchedule, new ShiftScheduleSingleCalendarTransformer());

        return response()->json($response,200);
    }
}