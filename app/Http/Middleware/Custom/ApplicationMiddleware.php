<?php

namespace App\Http\Middleware\Custom;

use Auth;
use Closure;

class ApplicationMiddleware
{
    /**
     * Handle an incoming request.
     * Accessible to NEW POTENTIAL DOCTORs who have not applied as doctors yet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && 
                (!Auth::user()->is_doctor 
                    && !Auth::user()->application()->count() 
                    && !Auth::user()->applicationIsRejected()
                )
            ){ return $next($request); }
        
        if (Auth::user()->is_doctor){
            flash('You are already a doctor on this platform and can apply once only!')->error();
        }
        if (Auth::user()->application()->count()){
            flash('You have an ongoing doctor\'s application on this platform currently. Only one application is allowed at a time.')->error();
        }
        if (Auth::user()->applicationIsRejected()){
            flash('You are not allowed to re-apply at the moment, please do on/after <b>'. Auth::user()->application_retry_at->format('F d, Y') .'</b> with valid documents.')->important()->error();
        }

        return back();//redirect()->route('users.show', Auth::user());
    } 
}