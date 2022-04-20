<?php

namespace App\Http\Controllers\Api\WaiterApi;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Item;
use App\Models\Resturant;
use App\Models\ResturantItemCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ItemController extends ApiBaseController
{
    public function getCategories(Request $request)
    {
        $user = auth()->user();
        $categories = $user->resturant->itemCategories;
        return $this->sendResponse($categories);
    }

    public function getItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "category_id" => "exists:resturant_item_categories,id"
        ]);
        if ($validator->fails())
            return $this->sendError($validator->errors());

        $user = auth()->user();

        $categoryId = $request->category_id;
        $branch = $user->branch;

//        $items = $user->branch->items();
        if ($categoryId)
        {
            $items =  Item::where('category_id',$categoryId);
        }
        $items = $items->branch($branch->id)->paginate(10);
        $items->appends(['category_id'=>$categoryId]);

        return $this->sendResponse($items);
    }

    public function updateItemAvailability(Request $request, Item $item)
    {
        $user = auth()->user();
        $branch = $user->branch;
        if(Hash::check($request->password,$branch->password)){
            $branch->changeItemAvailability($item,$request->is_available);
        }

        return $this->sendResponse(['message'=>'success']);
    }

    public function getItem(Item $item)
    {
        $item->load(['sides','sizes']);

        return $this->sendResponse($item);
    }
}
