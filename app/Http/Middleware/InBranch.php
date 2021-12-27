<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class InBranch
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
//        $user = Auth::user();
//        $branch = $user->active_cart->table->branch;
//        $lat = $request->header('Lat');
//        $lng = $request->header('Lng');
//        $distance = haversineGreatCircleDistance($lat, $lng, $branch->lat, $branch->lng);
//        $message = 'failed';
//        $errorMessage = '';
//        if($distance > $branch->range)
//        {
//            $errorMessage = 'You are not in the restaurant';
//        }
//        else
//        {
            return $next($request);
//        }
//        throw new HttpResponseException(response()->json(["message" => $message, "errors" => $errorMessage], 407));
    }
}
