<?php

namespace App\Account\Listeners;

use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/2/18
 * Time: 11:56 AM
 */
class LogAuthenticationAttempt
{

    use GlobalUtils;

    public function __construct()
    {

    }

    public function handle()
    {

        //Logging
        app()->make('LogService')->logging([
            'causer' => 'Undefined from IP: ' . \Request::ip(),
            'via' => 'web client| api client',
            'subject' => 'Auth Attempt',
            'action' => 'auth',
            'level' => 1,
            'description' => 'Undefined from IP: ' . \Request::ip() . ' Browser: ' . \Request::header('User-Agent') . ' attempts to log in',
            'causerIPAddress' => \Request::ip()
        ]);

    }

}