<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if( Auth::user()->isSuperAdmin()) return redirect('admin_panel/dashboard');
            if( Auth::user()->isAdmin()) return redirect('admin/dashboard');
            if( Auth::user()->isManager()) return redirect('manager/dashboard');
            if( Auth::user()->isUser()) return redirect('player/dashboard');
        }

        return $next($request);
    }
}
