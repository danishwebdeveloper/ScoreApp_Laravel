<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isManager
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
        $isManager = false;

        if(Auth::user()->isManager())
        {
            $isManager = true;
        }

        if(!$isManager)
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
