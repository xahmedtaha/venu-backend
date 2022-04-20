<?php

namespace App\Http\Controllers\Api\UserApi;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\Models\OAuthAccessToken;
use App\Http\Controllers\Api\ApiBaseController;
use Illuminate\Support\Facades\App;
use App\Models\Item;
use App\Models\Resturant;

class ItemController extends ApiBaseController
{
    //

    public function getProductsCategories(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "restuarantId"=>"required|exists:resturants,id",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors());

        $nameAttr = 'name_'.$request->header('accept-language');
        $resturantId = $request->restuarantId;
        $resturant = Resturant::find($resturantId);
        $categories = $resturant->productCategories;

        $response["productCategories"] = array();
        foreach($categories as $category)
        {
            $categoryObj["categoryID"] = $category->id;
            $categoryObj["categoryName"] = $category->$nameAttr;
            array_push($response["productCategories"],$categoryObj);
        }

        return $this->sendResponse($response);
    }

    public function getItemLists(Request $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        /**
         * @var Resturant $resturant
         */
        $resturant = $user->active_cart->table->resturant;
        $lists = $resturant->itemLists->load('items');
        return $this->sendResponse($lists);
    }

    public function getRestuarantItems(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "restuarant_id"=>"required|exists:resturants,id",
            "category_id"=>"exists:resturant_item_categories,id"
        ]);
        if($validator->fails())
            return $this->sendError($validator->errors());

        $resturantId = $request->restuarant_id;
        $categoryId = $request->category_id;

        $branchId = auth()->user()->active_cart->table->branch_id;

        if($categoryId)
        {
            $items = Item::where('resturant_id',$resturantId)->with(['sizes','sides'])->where('category_id',$categoryId);
        }
        else
        {
            $items = Item::where('resturant_id',$resturantId)->with(['sizes','sides']);
        }

        $items = $items->branch($branchId)->paginate(10);

        if($request->page)
        {
            $resturant = Resturant::find($resturantId);
            $resturant->visits()->create([
                'user_id' => Auth::user()->id
            ]);
        }
        return $this->sendResponse($items);

    }

    public function getItem(Item $item)
    {
        $item->load(['sides','sizes']);

        return $this->sendResponse($item);
    }

    public function getRestuarantSubProducts(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            "productId"=>"required|exists:products,id",
        ]);
        if($validator->fails())
            return $this->sendError($validator->errors());

        $productId = $request->productId;

        $product = Product::find($productId);
        $subProducts = $product->subProducts()->paginate(10);
        $nameAttr = 'name_'.$request->header('accept-language');
        $descriptionAttr = 'description_'.$request->header('accept-language');

        foreach($subProducts as $subProduct)
        {
            $subProduct["name"] = $subProduct->$nameAttr;
            $subProduct["photos"] = $subProduct->getImagesUrlArr();
            unset($subProduct["images"]);

            $subProduct["description"] = $subProduct->$descriptionAttr;

        }

        return $this->sendResponse($subProducts);

    }
}
