<?php

namespace App\Http\Controllers\BackendV1\API\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

    public function issueTokenWithResponse(Request $request, $grantType, $scope = "")
    {

        $guzzle = new Client();

        $response = $guzzle->post(URL::to('/').'/oauth/token', [
            'form_params' => [
                'grant_type' => $grantType,
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);



    }
}