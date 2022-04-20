<?php

namespace App\Http\Controllers\Api\UserApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\Models\OAuthAccessToken;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\BranchTable;
use App\Models\Resturant;
use App\Models\ResturantImage;
use App\Models\Category;
use App\Models\City;

class ResturantController extends ApiBaseController
{
    public function getCategories(Request $request)
    {
        $categories = Category::all();
        $response["categories"] = array();
        $nameAttr = "name_".$request->header("Accept-language");
        foreach($categories as $category)
        {
            $categoryJSON["categoryID"] = $category->id;
            $categoryJSON["categoryName"] = $category->$nameAttr;
            array_push($response["categories"],$categoryJSON);
        }
        return $this->sendResponse($response);
    }

    public function checkRate(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "RestaurantId"=>"required|exists:resturants,id",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors());
        $user = Auth::user();
        $resturantId = $request->RestaurantId;
        if($user->resturants->contains($resturantId))
        {
            $response["canOrder"] = true;
        }
        else
        {
            $response["canOrder"] = false;
        }
        return $this->sendResponse($response);
    }

    public function rate(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "resturant_id"=>"required|exists:resturants,id",
            "rate"=>"required",
            "review" => "max:191"
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors());

        $resturantId = $request->resturant_id;
        $ordertId = $request->order_id;
        $rate = $request->rate;
        $review = $request->review;
        $resturant = Resturant::find($resturantId);
//        $userRate = $resturant->rates()->where('user_id',Auth::user()->id)->first();
//        if($userRate)
//        {
//            $userRate->update(['rate'=>$rate,'review'=>$review]);
//        }
//        else
//        {
            $resturant->rates()->create([
                "user_id"=>Auth::user()->id,
                "rate"=>$rate,
                "review"=>$review,
                "order_id"=>$ordertId
            ]);
//        }

        $resturant->update([
                'rate'=>$resturant->calculateRate(),
            ]);
        $response["message"] = "success";
        return $this->sendResponse($response);
    }
}
