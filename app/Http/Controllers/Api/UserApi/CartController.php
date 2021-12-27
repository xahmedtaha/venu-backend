<?php

namespace App\Http\Controllers\Api\UserApi;

use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\CartRequest;
use App\Http\Requests\UserApi\DeleteCartItemRequest;
use App\Http\Requests\UserApi\EditCartItemRequest;
use App\Models\Cart;
use App\Http\Resources\Cart as CartResource;
use App\Models\Item;
use App\Models\ItemSide;
use App\Models\OrderedItem;
use App\Models\Size;

class CartController extends ApiBaseController
{
    public function getCart(Cart $cart)
    {
        return new CartResource($cart);
    }

    public function addToCart(CartRequest $request,Cart $cart)
    {
        $item = Item::find($request->item_id);
        $size = Size::find($request->size_id);
        $comment = $request->comment;
        //Hashing the item with md5 to easy check the existance of a new added item
        $serializedSides = serialize($request->sides);
        $hash = md5("$item->id $size->id $serializedSides");
        $orderedItem = $cart->orderedItems()->where('hash',$hash)
                            ->where('state',OrderedItem::STATE_IN_CART)->with(['sides'])->first();

        if(!$orderedItem)
        {
            $sub_total = $size->price_after * $request->quantity;
            $total = $sub_total;
            $orderedItem = $cart->orderedItems()->create([
                'item_id'=>$item->id,
                'size_id'=>$size->id,
                'order_id'=>$cart->order_id,
                'quantity'=>$request->quantity,
                'unit_price'=> $size->price_after,
                'sub_total' => $sub_total,
                'total'=> $total,
                'comment' => $comment
            ]);

            foreach($request->sides as $sideId)
            {
                $side = ItemSide::find($sideId);
                $orderedItem->sides()->create([
                    'side_id' => $side->id,
                    'weight' => $side->weight,
                    'price' => $side->price
                ]);
            }

            $orderedItem->update(['hash'=>$hash]);
            $orderedItem->calculate();
        }

        else
        {
            $quantity = $request->quantity + $orderedItem->quantity;
            $orderedItem->update([
                'quantity' => $quantity,
                'sub_total' => $quantity * $orderedItem->unit_price,
            ]);
            $orderedItem->calculate();
        }

        $cart->updateTotal();

        $cart->load('orderedItems');
        return new CartResource($cart);
    }

    public function editCartItem(EditCartItemRequest $request,Cart $cart)
    {
        $orderedItem = OrderedItem::find($request->cart_item_id);
        $size = Size::find($request->size_id);

        $serializedSides = serialize($request->sides);
        $hash = md5("$orderedItem->item_id $size->id $serializedSides");

        $orderedItem->update([
            'quantity' => $request->quantity,
            'size_id' => $request->size_id,
            'sub_total' => $request->quantity * $orderedItem->unit_price
        ]);

        $orderedItem->sides()->delete();
        foreach($request->sides as $side)
        {
            $side = ItemSide::find($side['side_id']);
            $orderedItem->sides()->create([
                'side_id' => $side->id,
                'weight' => $side->weight,
                'price' => $side->price
            ]);
        }
        $orderedItem->update(['hash'=>$hash]);

        $orderedItem->calculate();
        $cart->updateTotal();
        return new CartResource($cart);
    }

    public function deleteCartItem(Request $request, Cart $cart,OrderedItem $cartItem)
    {
        // $cartItem = OrderedItem::find($request->cart_item_id);
        $cartItem->sides()->delete();
        $cartItem->delete();
        $cart->updateTotal();
        return new CartResource($cart);
    }
}
