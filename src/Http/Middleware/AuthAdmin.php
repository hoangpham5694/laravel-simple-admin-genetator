<?php

namespace HoangPhamDev\SimpleAdminGenerator\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AuthAdmin
{
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if(!Auth::guard($guard)->check() ) {
            return redirect(route('sag.login'));
        }
        return $next($request);
    }
}