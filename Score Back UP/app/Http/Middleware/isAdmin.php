<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isAdmin
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
        $isAdmin = false;

        if(Auth::user()->isAdmin())
        {
            $isAdmin = true;
        }

        if(!$isAdmin)
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
