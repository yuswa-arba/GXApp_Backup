<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 23/12/17
 * Time: 3:15 PM
 */

namespace App\Attendance\Logics\Kiosk;


use Illuminate\Http\Request;

abstract class AuthUseCase
{
    public static function login(Request $request)
    {
        return (new static)->handleLogin($request);
    }

    public static function logout(Request $request)
    {
        return (new static)->handleLogout($request);
    }

    public static function activate(Request $request)
    {
        return (new static)->handleActivation($request);
    }

    abstract public function handleLogin($request);

    abstract public function handleLogout($request);

    abstract public function handleActivation($request);

}