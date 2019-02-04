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
        if (Auth::check() && 
            (Auth::user()->isAdmin() 
                || (Auth::user()->isDoctor())// && Auth::user()->doctor == \Route::input('doctor'))
                // || (Auth::user()->isDoctor() && Auth::id() == request()->user()->id))
                // || (Auth::user()->slug == \Route::input('user.slug'))
            )) {

            if (Auth::user()->isAuthenticatedAdmin() || Auth::user()->isAuthenticatedDoctor()) {
                return $next($request);
            }
            elseif(Auth::user()->isDoctor() && !Auth::user()->isAdmin()) {
                return redirect(route('doctor.login'));
            }
            elseif(Auth::user()->isAdmin() && !Auth::user()->isDoctor()) {
                return redirect(route('admin.login'));
            }
            
            return redirect(route('doctor.login'));
        }

        return abort('403', 'Unauthorized Access');


        // if (Auth::check()
        //     && (Auth::user()->isAuthenticatedAdmin()
        //         || (Auth::user()->isDoctor() && Auth::id() == request()->user()->id))
        //     ) {
        //     return $next($request);
        // }
        
        // return abort(403, 'Unauthorized access.');

    } 
}