<?php

namespace App\Http\Middleware\Custom;

use Auth;
use Closure;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     * Accessible to admin users who are NOT SIGNED IN as admin yet.
     * Equivalent of GUEST in normal user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdministrator()){

            if (Auth::user()->isAuthenticatedAdmin()) {
                return redirect(route('dashboard-main'));
            }
            else {
                return $next($request);
            }

        }

        return redirect(route('admin.login'));


        // if (Auth::check() && Auth::user()->isAdministrator()) {
        //     return $next($request);
        // }
        // elseif (Auth::check() && Auth::user()->isAuthenticatedAdmin()) {
        //     return redirect(route('dashboard-main'));
        // }

        // return redirect(route('admin.login'));
    } 
}

