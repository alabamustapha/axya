<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Auth;
use Cache;
use Carbon\Carbon;

class UserOnlineMiddleware
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
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(2);
            Cache::put('user-is-online-' . Auth::id(), true, $expiresAt);
        }
        return $next($request);
    }
}
