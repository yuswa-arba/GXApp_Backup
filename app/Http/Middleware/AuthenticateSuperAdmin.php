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

class AuthenticateSuperAdmin
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
        /* RUN LOGIC TO GET VALUE*/
        $this->logicCase($guard);

        $logicPassed = $this->superAdminAccess;

        if ($this->guest || $this->noAccess || !$logicPassed) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {

                if (!$this->guest) {
                    $request->session()->flash('alert-danger-bar-top', 'You don\'t have permission to access this page');
                }

                return redirect()->back();
            }
        }

        // Super Admin access is granted

        return $next($request);
    }
}