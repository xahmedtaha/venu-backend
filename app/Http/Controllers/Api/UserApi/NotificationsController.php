<?php

namespace App\Http\Controllers\Api\UserApi;

use App\Enums\NotificationTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\Models\OAuthAccessToken;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Guest;

class NotificationsController extends ApiBaseController
{
    //
   public function getNotifications(Request $request)
   {
        $user = Auth::user();
        $titleAttr = 'title_'.$user->lang;
        $descriptionAttr = 'description_'.$user->lang;
        $notifications = $user->notifications()->paginate(10);
        foreach($notifications as $notification)
        {
            $resturant = $notification->resturant;
            if($resturant)
                $notification['logo'] = $notification->resturant->getLogoUrl();
            else
                $notification['logo'] = env("APP_URL")."api/getPhoto/public/logo.jpeg";

            if($notification->type==NotificationTypes::ORDER_CHANGE_STATUS_CUSTOMER)
            {
                $notification['link'] = route('userApi.getOrderDetails',$notification->order->id);
            }
            elseif($notification->type == NotificationTypes::RESTAURANT_OFFER_CUSTOMER)
            {
                $notification['link'] = route('userApi.getResturant',$notification->resturant->id);
            }
            else
            {
                $notification['link'] = "";
            }
            $notification->title = $notification->$titleAttr;
            $notification->description = $notification->$descriptionAttr;
            unset($notification["resturant"]);
            unset($notification["order"]);
        }
        return $this->sendResponse($notifications);
   }
}
