<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\AssignSlotLogic;
use App\Attendance\Logics\GetCalendarLogic;
use App\Attendance\Logics\GetEmployeeListLogic;
use App\Attendance\Logics\GetShiftMappingCalendarLogic;
use App\Attendance\Logics\GetSlotListLogic;
use App\Attendance\Logics\MappingShiftLogic;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KioskController extends Controller
{
    use GlobalUtils;
    public function create(Request $request)
    {
        $response = array();

        //validate form
        $request->validate([
            'codeName' => 'required|unique:kiosks',
            'description' => 'required',
            'isActivated' => 'required',
        ]);

        //generate activation code
        $request->request->add(['activationCode' => $this->randomNumber(6)]);

        //is valid
        $kiosk = Kiosks::create($request->all());

        if ($kiosk) {
            $response['isFailed'] = false;
            $response['message'] = 'Kiosk has been created successfully';
            $response['kiosk'] = $kiosk;
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create Kiosk';
            return response()->json($response, 200);

        }

    }

    public function delete(Request $request)
    {
        $request->validate(['id'=>'required']);
        $delete = Kiosks::where('id',$request->id)->update(['isDeleted'=>1]);
        if ($delete) {
            $response['isFailed'] = false;
            $response['message'] = 'Kiosk has been deleted successfully';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to delete Kiosk';
            return response()->json($response, 200);

        }
    }

}
