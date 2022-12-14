<?php

namespace App\Http\Controllers\Api\WaiterApi;

use Illuminate\Http\Request;
use App\Models\ResturantOwner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Models\Order;
use Auth;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\OrderedItem;
use App\Models\Cart;

class OrderController extends ApiBaseController
{

    public function addItemToKitchen(OrderedItem $orderedItem,Request $request)
    {
        // dd($orderedItem);
        $orderedItem->update(['is_in_kitchen'=>1]);
        $order = $orderedItem->order;
        $order->calculate();
        return $this->sendResponse(['message'=>'success']);
    }

    public function removeItemToKitchen(OrderedItem $orderedItem,Request $request)
    {
        // dd($orderedItem);
        //$orderedItem->update(['state' => OrderedItem::STATE_IN_CART,'is_in_kitchen'=>0]);
        $order = $orderedItem->order;
        $orderedItem->sides()->delete();
        $orderedItem->delete();
        $order->calculate();
        return $this->sendResponse(['message'=>'success']);
    }

    public function placeOrder(Cart $cart, Request $request)
    {
        $order = $cart->order;
        $cart->orderedItems()->update(['state' => OrderedItem::STATE_IN_ORDER, 'is_in_kitchen'=>1]);

        $order->calculate();

        return $this->sendResponse(['message'=>'success']);
    }
}
