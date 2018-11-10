<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class ApplicationMiddleware
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
        if (Auth::check() && !Auth::user()->isDoctor() && !Auth::user()->application()->count()) {
            return $next($request);
        }
        
        if (Auth::user()->isDoctor()){
            flash('You are already a doctor on this platform and can apply once only!')->error();
            return redirect()->route('users.show', Auth::user());
        }

        flash('You have an ongoing doctor\'s application on this platform presently. Only one application is allowed at a time.')->error();
        return redirect()->route('users.show', Auth::user());
    } 
}