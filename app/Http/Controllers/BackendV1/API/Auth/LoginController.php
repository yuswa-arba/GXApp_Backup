<?php

namespace App\Http\Controllers\BackendV1\API\Auth;

use App\Account\Logics\Users\UserAuthLogic;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;

class LoginController extends Controller
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }

    public function login(Request $request)
    {
        return UserAuthLogic::login($request);
    }

    public function loginSuccessful()
    {
        return UserAuthLogic::loginSuccessful();
    }

    public function refresh(Request $request)
    {
        return UserAuthLogic::refresh($request);

    }

    public function logout(Request $request)
    {
        return UserAuthLogic::logout($request);
    }

    public function test()
    {
        $response = array();
        $response['testResult'] = true;
        $response['message'] = Carbon::now()->timestamp;

        return response()->json($response, 200);
    }

}
