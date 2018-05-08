<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Developer;


use App\Attendance\Transformers\ReportProblemTransformer;
use App\Fingerspot\Model\FingerspotDevice;
use App\Fingerspot\Transformers\FingerspotDeviceListTransformer;
use App\Http\Controllers\Controller;
use App\Log\Models\LogRequest;
use App\ReportProblem\Models\ReportProblem;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FingerspotController extends Controller
{

    use GlobalUtils;
    public function __construct()
    {

    }


    public function getList(Request $request)
    {

        $response = array();

        $fingerspotDevices = FingerspotDevice::all();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['fingerspotDevices'] = fractal($fingerspotDevices,new FingerspotDeviceListTransformer());

        return response()->json($response,200);
    }

    public function submit(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'server_ip'=>'required',
            'server_port'=>'required',
            'device_sn'=>'required',
            'is_activated'=>'required',
            'description'=>'required'
        ]);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameteres';
            return response()->json($response,200);
        }

        //is valid

        $insert =  FingerspotDevice::create([
            'server_ip'=>$request->server_ip,
            'server_port'=>$request->server_port,
            'device_sn'=>$request->device_sn,
            'is_activated'=>$request->is_activated,
            'description'=>$request->description
        ]);

        if($insert){
            $response['isFailed'] = false;
            $response['message'] = 'Successful';
            $response['fingerspotDevice'] = fractal($insert,new FingerspotDeviceListTransformer());
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to insert data';
            return response()->json($response,200);
        }
    }

    public function update(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameteres';
            return response()->json($response,200);
        }

        //is valid

        $update = FingerspotDevice::where('id',$request->id)->update([
            'server_ip'=>$request->serverIp,
            'server_port'=>$request->serverPort,
            'device_sn'=>$request->deviceSn,
            'is_activated'=>$request->isActivated,
            'description'=>$request->description,
        ]);

        if($update){
            $response['isFailed'] = false;
            $response['message'] = 'Successful';
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to insert data';
            return response()->json($response,200);
        }

    }

}
