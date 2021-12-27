<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Enums\FirebaseTopics;

class Notification extends Model
{
    //
    use HasTranslations;

    public $guarded = ['id'];

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function send($resturant_id)
    {
        //Initializing Firebase 
        $serviceAccount = ServiceAccount::fromJsonFile(base_path('app/Http/Controllers/foodbook-1e57c-532dba3bb098.json'));
        $firebase = (new Factory())->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://foodbook-1e57c.firebaseio.com/')->create();
        
        //Creating AR data json
        $data_ar = Notification::getNotificationDataObject();
        $data_ar["notificationType"] = $this->type;
        $data_ar_item["notificationType"] = $this->type;
        $data_ar_item["is_read"] = false;
        $data_ar_item["link"] = $resturant_id?route('userApi.getResturant',$resturant_id):"";
        $data_ar_item["title"] = $this->title_ar;
        $data_ar_item["desc"] = $this->description_ar;
        $data_ar["json"]["item"] = $data_ar_item;
        $data_ar["json"]["title"] = $this->title_ar;
        $data_ar["json"]["message"] = $this->description_ar;
        
        // dd($data_ar);
        //Creating EN data json
        $data_en = Notification::getNotificationDataObject();
        $data_en["notificationType"] = $this->type;
        $data_en_item["notificationType"] = $this->type;
        $data_en_item["is_read"] = false;
        $data_en_item["link"] = $resturant_id?route('userApi.getResturant',$resturant_id):"";
        $data_en_item["title"] = $this->title_en;
        $data_en_item["desc"] = $this->description_en;
        $data_en["json"]["item"] = $data_en_item;
        $data_en["json"]["title"] = $this->title_en;
        $data_en["json"]["message"] = $this->description_en;

        $fcm = $firebase->getMessaging();
        //Arabic Message
        $message_ar = CloudMessage::withTarget('topic',FirebaseTopics::foodbook_ar)
                    ->withData(["data"=>json_encode($data_ar)]);
        
        //English Message
        $message_en = CloudMessage::withTarget('topic',FirebaseTopics::foodbook_en)
                    ->withData(["data"=>json_encode($data_en)]);

        $fcm->sendAll([$message_ar,$message_en]);
    }

    public static function getNotificationDataObject()
    {
        $data=        
        [
            "notificationType" => 4,
            'json' => [
                "item" => [
                    "notificationType" => 4,
                    "is_read" => 0,
                    "link" => "",
                    "title" => "",
                    "desc" => "",
                ],
                "title" => "",
                "message" => ""

            ]
        ];
        return $data;
    }
}
