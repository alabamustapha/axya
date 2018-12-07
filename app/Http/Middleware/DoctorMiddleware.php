<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class DoctorMiddleware
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
        if (Auth::check() && Auth::user()->isDoctor()) {
            return $next($request);
        }
        
        return abort(403, 'Unathorized access.');//redirect()->route('home');

    } 
}