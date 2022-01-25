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
        $orderedItem->update(['is_in_kitchen'=>0]);
        $order = $orderedItem->order;
        $order->calculate();
        return $this->sendResponse(['message'=>'success']);
    }
}
