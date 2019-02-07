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
        if (Auth::check() && Auth::user()->isAdmin()) {
            if (Auth::user()->isAuthenticatedAdmin()) {
                return $next($request);
            }

            return redirect(route('admin.login'));
        }

        return abort('403', 'Unauthorized Access');
    } 
}

