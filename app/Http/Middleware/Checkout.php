<?php

namespace App\Http\Middleware;

use Illuminate\Http\Exceptions\HttpResponseException;

use Closure;

class Checkout
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
        $user = Auth::user();
        $cart = Cart::find($request->cart);
        $message = 'failed';
        $errorMessage = '';
        if($cart->active && $cart->user_id == $user->id)
        {
            return $next($request);
        }
        elseif($cart->user_id == $user->id)
        {
            $errorMessage = 'Not Your Cart';
        }
        throw new HttpResponseException(response()->json(["message" => $message, "errors" => $errorMessage], 406));
    }
}
