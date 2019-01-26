<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminAuthMiddleware
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
        if (Auth::check() && Auth::user()->isAdministrator()) {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->isAdmin()) {
            return redirect(route('dashboard-main'));
        }

        return redirect(route('admin.login'));
    } 
}

