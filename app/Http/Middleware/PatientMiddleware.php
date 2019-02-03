<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class PatientMiddleware
{
    /**
     * Handle an incoming request.
     * Accessible to DOCTORS and their PATIENTS only.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if  (Auth::check() 
            && ((Auth::id() == request()->user()->id) 
            // && ((Auth::user()->slug == \Route::input('user.slug'))
                || Auth::user()->isAdmin()
                // Currently accessed user is a patient to logged in doctor.
                || (Auth::user()->isDoctor() && Auth::user()->doctor->inAllPatients())
               )
            )
        { 
            return $next($request); 
        }
        return abort('403');
    }
}