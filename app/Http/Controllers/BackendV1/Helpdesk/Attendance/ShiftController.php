<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\AssignSlotLogic;
use App\Attendance\Logics\GetCalendarLogic;
use App\Attendance\Logics\GetEmployeeListLogic;
use App\Attendance\Logics\GetShiftMappingCalendarLogic;
use App\Attendance\Logics\GetSlotListLogic;
use App\Attendance\Logics\MappingShiftLogic;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\ShiftScheduleCalendarTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    public function create(Request $request)
    {

        $response = array();

        //validate form
        $request->validate([
            'name' => 'required',
            'workStartAt' => 'required',
            'workEndAt' => 'required',
//            'breakStartAt'=>'date_format:H:i',
//            'breakEndAt'=>'date_format:H:i'
        ]);


        $start = Carbon::createFromFormat('H:i', $request->workStartAt);
        $end = Carbon::createFromFormat('H:i', $request->workEndAt);

        // check if its over night
        if ($start->gt($end)) {
            $request->request->add(['isOvernight' => 1]);
        }

        //is valid
        $shift = Shifts::create($request->all());


        if ($shift) {
            $response['isFailed'] = false;
            $response['message'] = 'Shift has been created successfully';
            $response['shift'] = $shift;
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create Shift';
            return response()->json($response, 500);

        }

    }

    public function delete(Request $request)
    {
        $response = array();

        $request->validate(['shiftId' => 'required']);

        $slotBeingUse = SlotShiftSchedule::where('shiftId', $request->shiftId)->count();

        if ($slotBeingUse > 0) {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to delete Shift is currently being use';

        }

        $delete = Shifts::where('id', $request->shiftId)->delete();

        if ($delete) {
            $response['isFailed'] = false;
            $response['message'] = 'Shift has been deleted successfully';

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to delete Shift';

        }

        return response()->json($response, 200);

    }

    public function mapping(Request $request)
    {
        $request->validate([
            'slotId' => 'required',
            'shiftId' => 'required',
            'dateStart' => 'required',
            'dateEnd' => 'required'
        ]);

        return MappingShiftLogic::mapping($request);
    }

    public function getMappingCalendar(Request $request)
    {
        // by default mapping calendar only return day offs
        $request->validate(['slotIds' => 'required']);
        return GetShiftMappingCalendarLogic::getDayOffs($request);
    }

    public function getShiftScheduleOnCalendar(Request $request)
    {
        $request->validate(['slotIds' => 'required']);
        return GetShiftMappingCalendarLogic::getShiftSchedules($request);
    }

    public function removeSchedule(Request $request)
    {
        $request->validate(['id' => 'required']);

        $deleteSlotShiftSchedule = SlotShiftSchedule::where('id', $request->id)->delete();
        $response = array();
        if ($deleteSlotShiftSchedule) {
            $response['isFailed'] = false;
            $response['message']='Shift has been removed successfully';

        } else {
            $response['isFailed'] = true;
            $response['message']='Unable to remove shift';
        }

        return response()->json($response,200);


    }

    public function editSchedule(Request $request)
    {
        $request->validate(['id'=>'required','shiftId'=>'required']);

        $editSchedule = SlotShiftSchedule::where('id',$request->id)->update(['shiftId'=>$request->shiftId]);
        $response = array();
        if ($editSchedule) {
            $response['isFailed'] = false;
            $response['message']='Shift has been edit successfully';
            $response['slotShiftData'] = fractal( SlotShiftSchedule::find($request->id),new ShiftScheduleCalendarTransformer());

        } else {
            $response['isFailed'] = true;
            $response['message']='Unable to edit shift';
        }

        return response()->json($response,200);
    }


}
