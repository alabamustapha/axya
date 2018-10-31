<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class PatientProfileMiddleware
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
        if (Auth::check() 
            && ((Auth::id() == request()->user->id) 
                || Auth::user()->isSuperAdmin() 
                // || Auth::user()->inPastAttendantDoctors()
            )) {
            return $next($request);
        }
        return abort('403');
    }
}