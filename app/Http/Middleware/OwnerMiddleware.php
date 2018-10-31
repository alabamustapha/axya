<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class OwnerMiddleware
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
        if (Auth::check() && (Auth::id() == request()->user->id)) {
            return $next($request);
        }
        return back();
    }
}