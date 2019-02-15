<?php

namespace App\Http\Middleware\Custom;

use Auth;
use Closure;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     * Doctors only are granted access. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isDoctor()) {

            if (Auth::user()->isAuthenticatedDoctor() 
                // && Auth::user()->doctor->slug == \Route::input('doctor.slug')
            ) {
                return $next($request);
            }

            return redirect(route('doctor.login'));
        }
        
        return abort(403, 'Unauthorized access.');//redirect()->route('home');

    } 
}