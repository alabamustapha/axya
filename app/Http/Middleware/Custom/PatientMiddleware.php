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
        $doctor = Auth::user()->doctor;
        $userId = (\Route::input('user.slug')) 
                    ? \App\User::whereSlug(\Route::input('user.slug'))->first()->id
                    : \App\User::whereSlug(\Route::input('doctor.slug'))->first()->id
                    ;

        if (Auth::check()) {
            if (
                   Auth::user()->isAuthenticatedAdmin()  
                || (Auth::user()->slug == \Route::input('user.slug'))
                || (Auth::user()->isAuthenticatedDoctor() 
                        && (   $doctor->hasActivityWithPatient($userId) 
                            || $doctor->slug == \Route::input('doctor.slug')
                           )
                    )
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
        return abort('403');
        }
    }
}