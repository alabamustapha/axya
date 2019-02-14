<?php

namespace App\Http\Middleware\Custom;

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
        if (Auth::check()) {
            if (
                   Auth::user()->isAuthenticatedAdmin()  
                // || Auth::user()->isAuthenticatedDoctor() // Use policy to extend this.
                || (Auth::user()->slug == \Route::input('user.slug'))
                || (Auth::user()->isAuthenticatedDoctor() && Auth::user()->doctor->inAllPatients())
               ) 
            {
                return $next($request);
            }
            elseif (Auth::user()->isDoctor()) {// && !Auth::user()->isAdmin()
                return redirect(route('doctor.login'));
            }
            elseif (Auth::user()->isAdmin() && !Auth::user()->isDoctor()) {
                return redirect(route('admin.login'));
            }
        }

        // if  (Auth::check() 
        //     && (
        //         // Auth::id() == request()->user()->id
        //         Auth::user()->slug == \Route::input('user.slug')
        //         || Auth::user()->isAdmin()
        //         // Currently accessed user is a patient to logged in doctor.
        //         )
        //        )
        //     )
        // { 
        //     return $next($request); 
        // }
        return abort('403');
    }
}