<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\AssignSlotLogic;
use App\Attendance\Logics\GetCalendarLogic;
use App\Attendance\Logics\GetEmployeeListLogic;
use App\Attendance\Logics\GetSlotListLogic;
use App\Attendance\Models\Shifts;
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
            'name'=>'required',
            'workStartAt'=>'date_format:H:i|required',
            'workEndAt'=>'date_format:H:i|required',
            'breakStartAt'=>'date_format:H:i',
            'breakEndAt'=>'date_format:H:i'
        ]);


        $start = Carbon::createFromFormat('H:i',$request->workStartAt);
        $end = Carbon::createFromFormat('H:i',$request->workEndAt);

        // check if its over night
        if($start->gt($end)){
            $request->request->add(['isOvernight'=>1]);
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

}
