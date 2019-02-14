<?php

namespace App\Http\Middleware\Custom;

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
        if (Auth::check() && Auth::user()->isDoctor()){

            if (Auth::user()->isAuthenticatedDoctor()) {
                return redirect(route('dr_dashboard', Auth::user()->doctor));
            }
            else {
                return $next($request);
            }

        }

        return redirect(route('doctor.login'));
    } 
}

