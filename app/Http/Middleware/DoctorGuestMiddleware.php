<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class DoctorGuestMiddleware
{
    /**
     * Handle an incoming request.
     * Accessible to doctor users who are NOT SIGNED IN as doctor yet.
     * Equivalent of GUEST in normal user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isDoctor()) {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->isAuthenticatedDoctor()) {
            return redirect(route('dr_dashboard'));
        }

        return redirect(route('doctor.login'));
    } 
}

