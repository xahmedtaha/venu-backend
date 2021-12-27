<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;

class Location
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
        $lat = $request->header('Lat');
        $lng = $request->header('Lng');
        if(!$lng||!$lat)
        {
            throw new HttpResponseException(response()->json(["message" => "Lat and Lng is required",
                "errors" => 'Lat and Lng is required'], 407));
        }
        return $next($request);
    }
}
