<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;


use App\Attendance\Models\Kiosks;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KioskController extends Controller
{
    use GlobalUtils;

    public function __construct()
    {
        $this->middleware(['role:attendance operator']);
    }

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
        $request->validate(['id' => 'required']);
        $delete = Kiosks::where('id', $request->id)->update(['isDeleted' => 1]);
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

    public function edit(Request $request)
    {
        $request->validate(['kioskId' => 'required']);

        $kiosk = Kiosks::find($request->kioskId);
        if ($kiosk) {

            if($request->passcode){
                $kiosk->passcode = $request->passcode;
            }

            if($request->description){
                $kiosk->description = $request->description;
            }

            if($request->codeName){
                $kiosk->codeName = $request->codeName;
            }

            if($kiosk->save()){
                $response['isFailed'] = false;
                $response['message'] = 'Kiosk has been saved successfully';
                return response()->json($response, 200);
            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save kiosk';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Kiosk not found';
            return response()->json($response, 200);
        }


    }

}
