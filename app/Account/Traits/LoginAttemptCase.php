<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 9:28 PM
 */

namespace App\Account\Traits;


use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait  LoginAttemptCase
{

    use GlobalUtils;

    /* Default value */
    public $guest = true;
    public $noAccess = false;
    public $adminAccess = false;
    public $superAdminAccess = false;


    public function logicCase($guard)
    {
        if (!empty(Auth::guard($guard)) && !empty(Auth::guard($guard)->user())) {

            $this->noAccess = !Auth::guard($guard)->user()->accessStatusId;

            $this->adminAccess = Auth::guard($guard)->user()->allowAdminAccess;

            $this->superAdminAccess = Auth::guard($guard)->user()->allowSuperAdminAccess;
        }

        try{
            // Check if this user is set to specific employee
            // and check if this employee has resigned or not
            // if yes, set to no access
            $employee = Auth::guard($guard)->user()->employee;
            if($employee!=null){

                if($employee->hasResigned){
                    $this->noAccess = true;

                    $this->adminAccess = false;

                    $this->superAdminAccess = false;
                }

            }

        } catch (\Exception $exception){
            //do nothing
        }
    }

}