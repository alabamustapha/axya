<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isSuperAdminUser()) {

            if (Auth::user()->isLoggedInAsAdmin()) {
                return $next($request);
            }
            return redirect(route('admin.login'));

        }

        return abort('403', 'Unauthorized Access');
    }
}
