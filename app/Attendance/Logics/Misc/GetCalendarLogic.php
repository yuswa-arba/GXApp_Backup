<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Misc;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\PublicHolidayScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Traits\GlobalUtils;


class GetCalendarLogic extends GetDataUseCase
{
    use GlobalUtils;

    public function handle($request)
    {
        $response = array();

//        $dayOffSchedule = DayOffSchedule::where('slotId', $request->slotId)->get();
//        $shiftSchedule = SlotShiftSchedule::where('slotId', $request->slotId)->get();

        $dayOffSchedule = DayOffSchedule::where('slotId', $request->slotId)->where(function($query){
            $query->where('date','like','%'.$this->currentYear())->orWhere('date','like','%'.$this->lastYear());
        })->get();
        $shiftSchedule = SlotShiftSchedule::where('slotId', $request->slotId)->where(function($query){
            $query->where('date','like','%'.$this->currentYear())->orWhere('date','like','%'.$this->lastYear());
        })->get();
        $pubHolidaySchedule = PublicHolidaySchedule::where('fromSlotId',$request->slotId)->where(function($query){
           $query->where('applyDate','like','%'.$this->currentYear())->orWhere('applyDate','like','%'.$this->lastYear());
        })->get()->unique(function ($item){
            return $item['pubHolidayId'].$item['fromSlotId'];
        }); //prevent duplicated results

        $response['dayOffs'] = fractal($dayOffSchedule, new DayOffSingleCalendarTransformer());
        $response['shiftSchedules'] = fractal($shiftSchedule, new ShiftScheduleSingleCalendarTransformer());
        $response['pubHolidaySchedules'] = fractal($pubHolidaySchedule, new PublicHolidayScheduleSingleCalendarTransformer());

        return response()->json($response,200);
    }
}