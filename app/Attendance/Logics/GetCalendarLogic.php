<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotCalendarTransformer;
use App\Attendance\Transformers\SlotListTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetCalendarLogic extends GetSlotListUseCase
{


    public function handle($request)
    {
       $dayOffSchedule = DayOffSchedule::where('slotId',$request->slotId)->get();

       return fractal($dayOffSchedule,new SlotCalendarTransformer())->respond(200);
    }
}