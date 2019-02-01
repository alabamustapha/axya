<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class DoctorAuthMiddleware
{
    /**
     * Handle an incoming request.
     * Accessible to admin users who are NOT SIGNED IN as admin yet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isDoctorUser()) {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->isDoctor()) {
            return redirect(route('dr_dashboard'));
        }

        return redirect(route('doctor.login'));
    } 
}

