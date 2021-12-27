<?php

namespace App\Http\Middleware;

use App\Models\Guest;
use Closure;
use Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    
    public function handle($request, Closure $next, ...$guards)
    {
        $guestIndex = array_search("guest",$guards,true);
        if($guestIndex!=null)
        {
            $token = $request->header("Authorization");
            $token = str_after($token,"Bearer ");
            
            $guest = Guest::where('token',$token)->first();
            if($guest)
            {
                
                // app('auth')->guard('guest')->setUser($guest);
                Auth::login($guest);
                return $next($request);
            }
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
