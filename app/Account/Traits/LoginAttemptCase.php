<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 9:28 PM
 */

namespace App\Account\Traits;

use Illuminate\Support\Facades\Auth;

trait  LoginAttemptCase
{

    /* Default value */
    public $guest = true;
    public $noAccess = false;
    public $userAccess = false;
    public $adminAccess = false;
    public $superAdminAccess = false;


    public function logicCase($guard)
    {
        $this->guest = Auth::guard($guard)->guest();
        if (!empty(Auth::guard($guard)) && !empty(Auth::guard($guard)->user())) {

            $this->noAccess = !Auth::guard($guard)->user()->accessStatusId;

            $this->userAccess = Auth::guard($guard)->user()->allowUserAccess
                && !Auth::guard($guard)->user()->allowAdminAccess
                && !Auth::guard($guard)->user()->allowSuperAdminAccess;

            $this->adminAccess =  Auth::guard($guard)->user()->allowAdminAccess;

            $this->superAdminAccess = Auth::guard($guard)->user()->allowSuperAdminAccess;
        }
    }

}