<?php

namespace App\Http\Controllers\BackendV1\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait
{

    public function issueToken(Request $request, $grantType, $scope = "")
    {

        $params = [
            'grant_type' => $grantType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => $scope
        ];

        $params['username'] = $request->username ?: $request->email;


        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);

    }

    public function personalAccessToken()
    {
        $proxy = Request::create('/oauth/personal-access-tokens','GET');

        return Route::dispatch($proxy);
    }

}