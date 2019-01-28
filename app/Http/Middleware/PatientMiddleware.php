<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class PatientMiddleware
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
        if  (Auth::check() 
            // && ((Auth::user()->isAccountOwner()) 
            && ((Auth::id() == request()->user()->id) 
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