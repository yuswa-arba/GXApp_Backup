<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */
namespace App\Traits;


use App\Account\Models\UserPushToken;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use Illuminate\Support\Facades\Log;


trait FingerspotUtils
{

    public function sendRequestToFingerspotDevice($url, $port, $parameter)
    {
        $curl = curl_init();
        set_time_limit(0);
        curl_setopt_array($curl, array(
                CURLOPT_PORT => $port,
                CURLOPT_URL => "http://" . $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $parameter,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            )
        );
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $response = ("Error #:" . $err);
        }

        return $response;
    }
}