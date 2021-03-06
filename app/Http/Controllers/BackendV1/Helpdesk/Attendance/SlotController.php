<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;


use App\Attendance\Logics\Slot\CopySlotLogic;
use App\Attendance\Logics\Misc\GetCalendarLogic;
use App\Attendance\Logics\Misc\GetEmployeeListLogic;
use App\Attendance\Logics\Slot\GetSlotListLogic;
use App\Attendance\Logics\Slot\AssignSlotLogic;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\SlotListTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SlotController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view attendance']);
    }

    public function list(Request $request)
    {
        return GetSlotListLogic::getData($request);
    }

    public function copySlot(Request $request)
    {
        $validator = Validator::make($request->all(), ['copyFromSlotId' => 'required', 'name' => 'required|unique:slots','addBy'=>'required']);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Slot Id, name, and add by required. Make sure name is unique';
            return response()->json($response,200);
        }

        //is valid

        return CopySlotLogic::copy($request);
    }

    public function calendar(Request $request)
    {
        $validator = Validator::make($request->all(), ['slotId' => 'required']);
        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Slot ID required';
            return response()->json($response, 200);
        }

        //is valid

        return GetCalendarLogic::getData($request);
    }

    public function employeeList(Request $request)
    {
        $validator = Validator::make($request->all(), ['slotId' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Slot ID required';
            return response()->json($response, 200);
        }

        //is valid

        return GetEmployeeListLogic::getData($request);
    }

    public function assign(Request $request)
    {
        $validator = Validator::make($request->all(), ['slotId' => 'required','employeeId' => 'required|unique:employeeSlotSchedule']);
        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'An error occured!';
            return response()->json($response, 200);
        }

        return AssignSlotLogic::assign($request);
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), ['employeeId' => 'required']);
        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Employee ID required';
            return response()->json($response, 200);
        }


        return AssignSlotLogic::remove($request);
    }

    public function delete(Request $request)
    {
        /* Validate */
        $validator = Validator::make($request->all(), ['slotId' => 'required']);
        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Slot ID required';
            return response()->json($response, 200);
        }

        // is valid

        $slot = Slots::find($request->slotId);

        if ($slot->update(['isDeleted' => 1])) {
            $response['isFailed'] = false;
            $response['message'] = 'Slot has been deleted successfully';
            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Failed! Unable to delete slot';
            return response()->json($response, 200);
        }
    }

    public function editShiftOption(Request $request)
    {
        $request->validate(['slotId' => 'required', 'isUsingMapping' => 'required']);
        $updateSlot = Slots::where('id', $request->slotId)->update(['isUsingMapping' => $request->isUsingMapping]);

        $response = array();

        if ($updateSlot) {
            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Slot has been edit successfully';
            return response()->json($response, 200);
        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Failed! Unable to edit slot';
            return response()->json($response, 500);
        }
    }
}
