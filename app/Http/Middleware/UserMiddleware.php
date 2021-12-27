<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserMiddleware
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
        if(Auth::user()->tokens->first()->name=="user_app")
            return $next($request);
        else {
            return response()->json(["message"=>"Unauthenticated"],401);
        }
    }
}
