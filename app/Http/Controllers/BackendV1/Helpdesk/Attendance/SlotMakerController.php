<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\SlotMakerLogic;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Transformers\SlotMakerListTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlotMakerController extends Controller
{
    public function create(Request $request)
    {
        $response = array();

        //validate form
        $request->validate([
            'name'=>'required|unique:slotMaker',
            'firstDate' => 'date_format:"d/m/Y"|required',
            'totalDayLoop' => 'required|numeric|min:1',
            'workingDays' => 'required|numeric|min:1',
        ]);

        // validate if its related to job position or not
        // if it does, make sure jobposition is not empty
        if ($request->relatedToJobPosition == 1 && $request->jobPositionId == '') {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create Slot Maker, form is not valid';
            return response()->json($response, 500);
        }

        // is valid

        $slotMaker = SlotMaker::create($request->all());

        if ($slotMaker) {
            $response['isFailed'] = false;
            $response['message'] = 'Slot Maker has been created successfully';
            $response['slotMaker'] = $slotMaker;
            $response['slotMaker']['jobPosition'] = !is_null($slotMaker->jobPosition)?$slotMaker->jobPosition->name:'';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create Slot Maker';
            return response()->json($response, 500);

        }
    }

    public function list()
    {
        $slotMakers = SlotMaker::all();
        return fractal($slotMakers, new SlotMakerListTransformer())->respond(200);
    }

    public function execute(Request $request)
    {
        $request->validate(['id' => 'required']);
        return SlotMakerLogic::execute($request);
    }
}
