<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isPlayer
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
        $isPlayer = false;

        if(Auth::user()->isPlayer())
        {
            $isPlayer = true;
        }

        if(!$isPlayer)
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
