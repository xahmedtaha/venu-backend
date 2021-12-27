<?php

namespace App\Http\Controllers\Api\UserApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\Models\OAuthAccessToken;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Guest;
use App\Models\Place;
use App\Models\Resturant;
use App\Models\SiteConfig;
use App\Models\User;
class GuestController extends ApiBaseController
{
    //
    public function getToken(Request $request)
    {
        $guest = Guest::where('device_id',$request->header('device_id'))->first();
        if($guest==null)
        {
            $guest = Guest::create(
                [
                    'device_id' => $request->header('device_id'),
                ]);
        }
        $token = Auth::guard('guest')->login($guest);

        $response["tempToken"] = $token;
        return $this->sendResponse($response);
    }

    public function getPlaces(Request $request)
    {
        $places = Place::all();
        $nameAttr = "name_".$request->header('accept-language');
        $response["places"] = array();
        foreach($places as $place)
        {
            $placeObj["placeId"] = $place->id;
            $placeObj["placeName"] = $place->$nameAttr;
            $placeObj["cities"] = array();
            foreach($place->cities as $city)
            {
                $cityObj["Id"] = $city->id;
                $cityObj["cityName"] = $city->$nameAttr;
                array_push($placeObj["cities"],$cityObj);
            }
            array_push($response["places"],$placeObj);
        }

        return $this->sendResponse($response);
    }

    public function getTerms(Request $request)
    {
        $termsAttr = 'terms_'.$request->header('accept-language');
        $terms = SiteConfig::find($termsAttr);
        $response["terms"] = $terms->value;
        return $this->sendResponse($response);
    }

    public function getOptions(Request $request)
    {
        $response["options"]["minDeliveryCost"] = Resturant::min('delivery_cost');
        $response["options"]["maxDeliveryCost"] = Resturant::max('delivery_cost');
        $response["options"]["minOffer"] = Resturant::min('discount');
        $response["options"]["maxOffer"] = Resturant::max('discount');
        $response["options"]["minDeliveryTime"] = Resturant::min('delivery_time');
        $response["options"]["maxDeliveryTime"] = Resturant::max('delivery_time');
        return $this->sendResponse($response);
    }

    public function GetLastOrder(Request $request)
    {
        $response["haveLastOrder"] = false;
        $response["RestaurantId"] = "";
        $response["RestaurantName"] = "";
        if(Auth::user() instanceof User)
        {
            $order = Auth::user()->orders()->where('status',3)->where('rated',0)->orderBy('id','desc')->first();
            if($order)
            {
                $nameAttr = "name_".$request->header('accept-language');
                $response["haveLastOrder"] = true;
                $response["RestaurantId"] = $order->resturant_id;
                $response["RestaurantName"] = $order->resturant->$nameAttr;
                $order->update(["rated"=>1]);
            }
        }
        return $this->sendResponse($response);
    }
}
