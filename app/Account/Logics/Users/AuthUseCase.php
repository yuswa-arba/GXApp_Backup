<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 23/12/17
 * Time: 3:15 PM
 */

namespace App\Account\Logics\Users;

use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class AuthUseCase
{
    public static function login(Request $request)
    {
        return (new static)->handleLogin($request);
    }

    public static  function loginSuccessful()
    {
        return (new static)->handleLoginSuccessful();
    }

    public static function logout(Request $request)
    {
        return (new static)->handleLogout($request);
    }

    public static function refresh(Request $request)
    {
        return (new static)->handleRefresh($request);
    }



    abstract public function handleLogin($request);

    abstract public function handleLoginSuccessful();

    abstract public function handleLogout($request);

    abstract public function handleRefresh($request);

}