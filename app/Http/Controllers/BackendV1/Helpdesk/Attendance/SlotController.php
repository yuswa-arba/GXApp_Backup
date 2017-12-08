<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\GetCalendarLogic;
use App\Attendance\Logics\GetEmployeeListLogic;
use App\Attendance\Logics\GetSlotListLogic;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlotController extends Controller
{
    public function list(Request $request)
    {
      return GetSlotListLogic::getData($request);
    }

    public function calendar(Request $request)
    {
        $request->validate(['slotId'=>'required']);
        return GetCalendarLogic::getData($request);
    }

    public function employeeList(Request $request)
    {
        $request->validate(['slotId'=>'required']);
        return GetEmployeeListLogic::getData($request);
    }


}
