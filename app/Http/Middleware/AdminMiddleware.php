<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Accessible to admin users who are SIGNED IN as an admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(Auth::user()->isLoggedInAsAdmin());
        // dd(Auth::user()->is_verified && (Auth::user()->acl == '1' || Auth::user()->isSuperAdminUser()),
        // Auth::user()->is_verified,
        // Auth::user()->acl == '1',
        // Auth::user()->acl == '5',
        // Auth::user()->isSuperAdminUser(), 
        // (Auth::user()->acl == '1' || Auth::user()->isSuperAdminUser()), 
        // Auth::user()->isAdminUser());
        if (Auth::check() && Auth::user()->isAdminUser()) {

            if (Auth::user()->isLoggedInAsAdmin()) {
                return $next($request);
            }
            return redirect(route('admin.login'));

        }
        else {
            return abort('403', 'Unauthorized Access');
        }

        // if (Auth::check() && Auth::user()->isAdmin()) {
        //     return $next($request);
        // }
        
        // return abort(403);
    } 
}

