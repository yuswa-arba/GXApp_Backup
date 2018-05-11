<?php

namespace App\Log\Services;

use App\Log\Models\LogRequest;
use Illuminate\Support\Facades\Log;

class LogService
{

    public function __construct()
    {

    }


    public function logging($data = array())
    {
        if ($data['causer'] &&
            $data['via'] &&
            $data['subject'] &&
            $data['action'] &&
            $data['level'] &&
            $data['description']
        ) {
            // use try catch to prevent error and stopping the process
            try{
                LogRequest::create($data);
            } catch (\Exception $exception){
                Log::error($exception->getMessage());
            }

        }
    }


}