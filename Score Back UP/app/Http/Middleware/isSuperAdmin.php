<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isSuperAdmin
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
        $isSuperAdmin = false;

        if(Auth::user()->isSuperAdmin())
        {
            $isSuperAdmin = true;
        }

        if(!$isSuperAdmin)
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            } 
            else 
            {
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
