<?php

namespace App\Http\Middleware\Pages\Users;

use Closure;
use Illuminate\Support\Facades\Auth;

class BiodataMiddleware
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
            if (Auth::user()->isOther() &&
                Auth::user()->get_bio->tgl_lahir != null && Auth::user()->get_bio->jenis_kelamin != null &&
                Auth::user()->get_bio->alamat != null && Auth::user()->get_bio->kota_id != null && Auth::user()->get_bio->hp != null) {
                return $next($request);
            }

        } else {
            return $next($request);
        }

        return redirect()->route('user.profil');
    }
}
