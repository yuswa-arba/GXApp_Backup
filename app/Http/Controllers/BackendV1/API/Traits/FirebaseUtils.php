<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */
namespace App\Http\Controllers\BackendV1\API\Traits;


use App\Account\Models\UserPushToken;
use App\Traits\GlobalConst;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;


trait FirebaseUtils
{


    public function sendSinglePush($userID, $title, $message, $image, $intentType, $type)
    {
        //getting the token from database object
        if ($userID != null && $type != null) {

            if($title==null||$title==''){
                $title = 'GXApp Employee'; //default
            }

            //creating a new push
            $push = null;

            //if the push don't have an image give null in place of image
            $push = array();
            $push['data']['title'] = $title;
            $push['data']['message'] = $message;
            $push['data']['intentType'] = $intentType;
            $push['data']['image'] = null;

            //getting the push from push object
            $mPushNotification = $push;

            $devicetoken = UserPushToken::where('userId', $userID)->where('type', $type)->orderBy('id', 'desc')->first()['token'];

            $this->send(array($devicetoken), $mPushNotification); //required as an array
        }
    }

    public function send($registration_ids, $message)
    {
        $fields = array(
            'priority'=>'high',
            'registration_ids' => $registration_ids,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    /*
    * This function will make the actuall curl request to firebase server
    * and then the message is sent
    */
    private function sendPushNotification($fields)
    {

        $FIREBASE_API_KEY = GlobalConst::$FIREBASE['SERVER_KEY'];

        $url = GlobalConst::$FIREBASE['URL'];

        //building headers for the request
        $headers = array(
            'Authorization: key=' . $FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        //Initializing curl to open a connection
        $ch = curl_init();

        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);

        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        //finally executing the curl request
        $result = curl_exec($ch);

        if ($result === FALSE) {
            \Illuminate\Support\Facades\Log::info(curl_error($ch));
            die('Curl failed: ' . curl_error($ch));
        }
        //Now close the connection
        curl_close($ch);

        //and return the result
        return $result;
    }
}