<?php

namespace App\Http\Middleware\Pages\Users;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->isOther()) {
                return $next($request);
            }

        } else {
            return $next($request);
        }

        return response()->view('errors.403');
    }
}
