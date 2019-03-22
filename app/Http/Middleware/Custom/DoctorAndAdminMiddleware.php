<?php

namespace App\Http\Middleware\Custom;

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
        if (
            Auth::check() && 
                (
                Auth::user()->isAdmin() || 
                    (
                        \Route::input('doctor') 
                        ? ( Auth::user()->is_doctor && 
                            Auth::user()->doctor->slug == \Route::input('doctor.slug')) 
                        : Auth::user()->is_doctor
                    )
                )
            )
        {

            if (Auth::user()->isAuthenticatedAdmin() || Auth::user()->isAuthenticatedDoctor()) {
                return $next($request);
            }
            elseif(Auth::user()->is_doctor && !Auth::user()->isAdmin()) {
                return redirect(route('doctor.login'));
            }
            elseif(Auth::user()->isAdmin() && !Auth::user()->is_doctor) {
                return redirect(route('admin.login'));
            }
            
            return redirect(route('doctor.login'));
        }

        return abort('403', 'Unauthorized Access');


        // if (Auth::check()
        //     && (Auth::user()->isAuthenticatedAdmin()
        //         || (Auth::user()->is_doctor && Auth::id() == request()->user()->id))
        //     ) {
        //     return $next($request);
        // }
        
        // return abort(403, 'Unauthorized access.');

    } 
}