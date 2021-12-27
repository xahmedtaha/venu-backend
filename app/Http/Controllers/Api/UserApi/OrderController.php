<?php

namespace App\Http\Controllers\Api\UserApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\Models\OAuthAccessToken;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Order as ResourcesOrder;
use App\Http\Resources\SimpleOrder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\Resturant;
use App\Models\Product;
use App\Models\SubProduct;
use Kreait\Firebase\Factory;

class OrderController extends ApiBaseController
{
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cart = $user->active_cart;
        $order = $cart->order;
        $cart->orderedItems()->update(['state' => OrderedItem::STATE_IN_ORDER]);

        $order->calculate();

        return new ResourcesOrder($order);
    }

    public function getPlacedOrder(Request $request)
    {
        $user = Auth::user();
        $cart = $user->active_cart;
        $order = $cart->order;
        return new ResourcesOrder($order);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = $user->active_cart;
        $table = $cart->table;
        $order = $cart->order;
        $table->requestCheckout();
        // $table->clear();
        // $order->close();
        return new ResourcesOrder($order);
    }

    public function getOrders(Request $request)
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return SimpleOrder::collection($orders);
    }

    public function getOrderDetails(Request $request,Order $order)
    {
        return new ResourcesOrder($order); //Resource
    }

    public function testFirestore()
    {
        $factory = new Factory();
        $firestore = $factory->withServiceAccount(config('app.firebase_service_account'))->createFirestore();
        $database = $firestore->database();
        $branchesDocument = $database->collection('staging')->document('branch')->snapshot();
        dd($branchesDocument);
    }
}
