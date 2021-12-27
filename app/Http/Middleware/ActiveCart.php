<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Illuminate\Http\Exceptions\HttpResponseException;
use Closure;
use Illuminate\Support\Facades\Auth;
class ActiveCart
{
    /**
     * Handle an incoming request.
     * Middleware for cart crud to enusre that the cart is active and is the user's cart
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $cart = $user->active_cart;
        $message = 'failed';
        $errorMessage = '';
        if(!$cart)
        {
            $errorMessage = 'You are not in table';
        }
        elseif($cart && $cart->user_id == $user->id)
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
