<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class DoctorAndAdminMiddleware
{
    /**
     * Handle an incoming request.
     * Doctors and admins only are granted access.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()
            && (Auth::user()->isAdmin()
                || (Auth::user()->isDoctor() && Auth::id() == request()->user()->id))
            ) {
            return $next($request);
        }
        
        return abort(403, 'Unathorized access.');

    } 
}