<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 3:54 PM
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()
            || !Auth::guard($guard)->user()->accessStatusId
            || !Auth::guard($guard)->user()->allowUserAccess
        ) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                Auth::logout();
                $request->session()->flash('alert-danger', 'You don\'t have permission to access this page');
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}