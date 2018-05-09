<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Misc;


use App\Http\Controllers\Controller;

use App\Notification\Logics\Send\SendSingleNotificationLogic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{

    public function sendSingleNotification(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(),[
            'employeeId'=>'required',
            'message'=>'required',
            'viaType'=>'required'
        ]);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';
            return response()->json($response,200);
        }

        //is valid

        return SendSingleNotificationLogic::notify($request);

    }

}
