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
class LogFailedLogin
{

    use GlobalUtils;
    public function __construct()
    {

    }

    public function handle()
    {
        //Logging
        if( Auth::check()) {
            app()->make('LogService')->logging([
                'causer' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
                'via' => 'web client| api client',
                'subject' => 'Auth Failed',
                'action' => 'auth',
                'level' => 1,
                'description' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName') . ' has failed to log in',
                'causerIPAddress' => \Request::ip()
            ]);
        }
    }

}