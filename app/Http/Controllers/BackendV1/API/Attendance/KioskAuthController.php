<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Account\Traits\TokenUtils;
use App\Attendance\Logics\AttendanceLogic;
use App\Attendance\Models\Kiosks;
use App\Http\Controllers\BackendV1\API\Auth\IssueTokenTrait;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;

class KioskAuthController extends Controller
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(5);
    }

    public function login(Request $request)
    {
        return $this->issueToken($request, 'client_credentials');
    }

    public function getApiToken(Request $request)
    {
        $request->validate(['kioskId'=>'required']);
        $kiosk = Kiosks::find($request->kioskId);
        $response = array();
        if($kiosk&&$kiosk->apiToken!=null){
            $response['isFailed'] = false;
            $response['message']= 'Ok';
            $response['apiToken']= $kiosk->apiToken;
        } else {
            $response['isFailed'] = false;
            $response['message']= 'Kiosk api token not found';
        }

        return response()->json($response,200);

    }

    public function updateAccessToken(Request $request)
    {
        $this->validate($request, [
            'kioskId' => 'required',
            'access_token' => 'required'
        ]);

        Kiosks::where('id', $request->kioskId)->update(['api_token' => $request->access_token]);

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Kiosk access token updated';
        return response()->json($response, 200);
    }

    public function removeAccessToken(Request $request)
    {
        $this->validate($request, [
            'kioskId' => 'required',
        ]);

        Kiosks::where('id', $request->kioskId)->update(['api_token' => '']);

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Kiosk access token removed';
        return response()->json($response, 200);
    }

    public function test()
    {
        $response = array();
        $response['testResult'] = true;
        $response['message'] = Carbon::now()->timestamp;

        return response()->json($response, 200);
    }
}
