<?php

namespace App\Account\Traits;

use App\Account\Models\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;


/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 10:07 AM
 */
trait TokenUtils
{
    private $accessToken;

    public function __construct()
    {
        $this->accessToken = !is_null(Auth::guard('api')->user()) ? Auth::guard('api')->user()->token() : '';
    }

    public function getOAuthAccessToken()
    {
        if ($this->accessToken != '') {
            return $this->accessToken;
        } else {
            return response()->json(401); // return Unauthorized error
        }

    }

    public function getOAuthClient()
    {
        if ($this->accessToken != '') {
            $client = Client::find($this->accessToken->client_id);
            return $client;
        } else {
            return response()->json(401); // return Unauthorized error
        }

    }


    public function getUserByAccessToken()
    {
        if ($this->accessToken != '') {
            $user = User::find($this->accessToken->user_id);
            return $user;
        } else {
            return response()->json(401); // return Unauthorized error
        }

    }

    public function getEmployeeByAccessToken()
    {
        if ($this->accessToken != '') {
            $user = User::find($this->accessToken->user_id);
            return $user->employee;
        } else {
            return response()->json(401); // return Unauthorized error
        }

    }
}
