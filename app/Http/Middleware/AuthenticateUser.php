<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 3:54 PM
 */

namespace App\Http\Middleware;


use App\Account\Traits\LoginAttemptCase;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{

    use LoginAttemptCase;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        /*Check if its guest*/
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        /* RUN LOGIC TO GET VALUE*/
        $this->logicCase($guard);

        if ( $this->noAccess ) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {

                if (!$this->guest) {
                    $request->session()->flash('alert-danger', 'You don\'t have permission to access this page');
                }

                Auth::logout();
                return redirect()->route('login');

            }
        }

        return $next($request);
    }
}