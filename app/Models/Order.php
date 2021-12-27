<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Enums\NotificationTypes;
use Carbon\Carbon;
use Auth;
use Exception;

class Order extends Model
{
    //
    use SoftDeletes;

    const STATUS_ACTIVE = 0;
    const STATUS_CLOSED = 1;

    protected $guarded = ['id'];

    protected $casts = [
        'branch_id' => 'integer',
        'tax_value' => 'float',
        'service_value' => 'float',
        'sub_total' => 'float',
        'total' => 'float',
        'order_number' => 'integer',
        'table_id' => 'integer',
        'resturant_id' => 'integer',
        'discount' => 'float',
        'status' => 'integer',
        'number_of_products' => 'integer'
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class)->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function table()
    {
        return $this->belongsTo(BranchTable::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class)->withTrashed();
    }

    public function rates()
    {
        return $this->hasMany(Rate::class)->with('user');
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class)->where('state',OrderedItem::STATE_IN_ORDER)->where('is_in_kitchen',1);
    }

    public function placedItems()
    {
        return $this->hasMany(OrderedItem::class)->where('state',OrderedItem::STATE_IN_ORDER);
    }

    public function calculate()
    {
        $subTotal = $this->orderedItems()->sum('total');
        $tax = $this->resturant->vat_on_total ? $this->resturant->vat_value : 0;
        $taxValue = 0;
        $service = $this->resturant->service??0;
        $serviceValue = 0;

        $serviceValue = ($service / 100) * $subTotal;
        $taxValue = ($tax / 100) * ($subTotal + $serviceValue);
        $total = $subTotal + $taxValue + $serviceValue;

        $this->update([
            "sub_total" => $subTotal,
            "tax" => $tax,
            "tax_value" => $taxValue,
            "service" => $service,
            "service_value" => $serviceValue,
            "total" => $total,
            "number_of_products" => $this->orderedItems()->count(),
            "num_of_placed_items" => $this->placedItems()->count(),
        ]);
    }

    public function close()
    {
        $this->update(['status'=>self::STATUS_CLOSED]);
    }

    public function getPreparedAt()
    {
        $preparedStatusTime = $this->statuses()->where('status',1)->first();
        if(!$preparedStatusTime)
            return null;
        else
            return $preparedStatusTime->created_at;
    }

    public function getPredictedDeliveredAt()
    {
        $preparedStatusTime = $this->statuses()->where('status',1)->first();
        if(!$preparedStatusTime)
            return '0';
        $preparedStatusTime = $preparedStatusTime->created_at;
        $deliveryTime = $this->resturant->delivery_time;
        $preparedTime = Carbon::parse($preparedStatusTime);
        $preparedTime = $preparedTime->addMinutes($deliveryTime);
        $predicted = $preparedTime;
        return $predicted;
    }

    public function changeStatus($status)
    {
        $this->update(["status"=>$status]);
        $this->sendFirebaseStatusChangeNotification();
        $this->insertNotificationIntoDatabase();
        $this->statuses()->create(
            [
                'emp_id'=>Auth::user()->id,
                'status'=>$status,
                'note'=>null,
            ]);
        $this->sendUserNotification();
    }

    public function sendFirebaseStatusChangeNotification()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(base_path('app/Http/Controllers/foodbook-1e57c-532dba3bb098.json'));
        $firebase = (new Factory())->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://foodbook-1e57c.firebaseio.com/')->create();
        $database = $firebase->getDatabase();
        $newOrder = $database->getReference("restaurants/".$this->resturant->id."/".$this->id)->update(['orderStatus'=>$this->status]);
    }

    public function sendFirebaseCreationNotification($order)
    {
        $serviceAccount = ServiceAccount::fromJsonFile(base_path('app/Http/Controllers/foodbook-1e57c-532dba3bb098.json'));
        $firebase = (new Factory())->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://foodbook-1e57c.firebaseio.com/')->create();
        $this->insertIntoFirebaseDatabase($order,$serviceAccount,$firebase);
        $this->sendOwnerNotification($order,$serviceAccount,$firebase);
    }

    public function insertIntoFirebaseDatabase(Order $order,ServiceAccount $serviceAccount,$firebase)
    {

        $database = $firebase->getDatabase();
        $newOrder = $database->getReference("restaurants/".$order->resturant->id."/".$order->id)->set([
            "orderAddress" => $order->address->address,
            "orderDate"=>$order->created_at->format('Y-m-d H:i:sa'),
            "orderLink" => route('resturantApi.getOrderDetails',$order->id),
            "orderWebLink" => route('orders.ajax.getOrderDetails',$order->id),
            "orderNumber"=> "#".$order->order_number,
            "orderPrice"=>$order->total,
            "orderStatus" => 0]);
    }

    public function sendOwnerNotification($order,ServiceAccount $serviceAccount, $firebase)
    {
        $resturant_owner = $order->resturant->owners()->first();
        if(!$resturant_owner || !$resturant_owner->fcm_token)
            return false;

        $data=
        [
            "notificationType" => 4,
            'json' => [
                "item" => [
                    "notificationType" => 4,
                    "is_read" => 0,
                    "link" => "wwwww",
                    "title" => "New Order Arrived",
                    "desc" => "New Order arrived to you from user:".$order->user->name_en,
                ],
                "title" => "New Order Arrived",
                "message" => "New Order arrived to you from user:".$order->user->name_en

            ]
        ];
        // dd(json_encode($data));

        $fcm = $firebase->getMessaging();

        $message = CloudMessage::withTarget('token',$resturant_owner->fcm_token)
                    ->withData(["data"=>json_encode($data)]);
        try {
            $fcm->send($message);
        } catch (Exception $ex) {

        }
    }

    public function sendUserNotification()
    {
        if(!$this->user->firebase_token)
            return;
        $serviceAccount = ServiceAccount::fromJsonFile(base_path('app/Http/Controllers/foodbook-1e57c-532dba3bb098.json'));
        $firebase = (new Factory())->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://foodbook-1e57c.firebaseio.com/')->create();
        $lang = $this->user->lang;

        $data = Notification::getNotificationDataObject();
        $data["notificationType"] = NotificationTypes::ORDER_CHANGE_STATUS_CUSTOMER;
        $data_item["notificationType"] = NotificationTypes::ORDER_CHANGE_STATUS_CUSTOMER;
        $data_item["is_read"] = false;
        $data_item["link"] = route('userApi.getOrderDetails',$this->id);
        $data_item["title"] = ($lang=='ar'?Order::STATUS_CHANGE_TEXT_AR:Order::STATUS_CHANGE_TEXT_EN).$this->order_number;
        $data_item["desc"] = $lang=='ar'?Order::statusAr[$this->status]:Order::statusEn[$this->status];
        $data["json"]["item"] = $data_item;
        $data["json"]["title"] = ($lang=='ar'?Order::STATUS_CHANGE_TEXT_AR:Order::STATUS_CHANGE_TEXT_EN).$this->order_number;
        $data["json"]["message"] = $lang=='ar'?Order::statusAr[$this->status]:Order::statusEn[$this->status];

        $fcm = $firebase->getMessaging();
        $message = CloudMessage::withTarget('token',$this->user->firebase_token)
                    ->withData(["data"=>json_encode($data)]);
        try {
            $fcm->send($message);
        } catch (Exception $ex) {

        }
    }

    public function insertNotificationIntoDatabase()
    {
        $notifcation = Notification::create([
            'user_id' => $this->user->id,
            'resturant_id' => $this->resturant->id,
            'order_id' => $this->id,
            'type' =>  NotificationTypes::ORDER_CHANGE_STATUS_CUSTOMER,
            'sent_by' => Auth::user()->id,
            'title_ar'=>Order::STATUS_CHANGE_TEXT_AR . $this->order_number,
            'title_en'=>Order::STATUS_CHANGE_TEXT_EN . $this->order_number,
            'description_ar'=>Order::statusAr[$this->status],
            'description_en'=>Order::statusEn[$this->status],
        ]);
    }

    public function deleteFromFirebase()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(base_path('app/Http/Controllers/foodbook-1e57c-532dba3bb098.json'));
        $firebase = (new Factory())->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://foodbook-1e57c.firebaseio.com/')->create();
        $database = $firebase->getDatabase();

        $orderReference = $database->getReference("restaurants/".$this->resturant->id."/".$this->id)->remove();

    }
    public static function getOrderAsJson(Order $order,$lang)
    {
        $response["id"] = $order->id;
        $response["resturantName"] = $order->resturant->display_name;
        $response["resturantId"] = $order->resturant->id;
        $response["date"] = $order->created_at->format('Y-m-d h:i:s a');
        $response["time"] = $order->created_at->format('H:i:s');
        $response["total"] = $order->total;
        $response["subtotal"] = $order->subtotal;
        $response["discount"] = $order->discount;
        $response["deliveryCost"] = $order->delivery_cost;
        $response["tax"] = $order->tax;
        $response["status"] = $order->status;
        $response["rejectReason"] = $order->reject_reason;
        $response["orderNumber"] = $order->order_number;
        $orderProducts = $order->products;
        $orderProductsArr = array();
        $name_attr = "name_".$lang;
        foreach($orderProducts as $orderProduct)
        {
            $product["productId"] = $orderProduct->product_id;
            $product["productName"] = $orderProduct->product->$name_attr;
            $productPhotos = $orderProduct->product->images;
            $photos = array();
            foreach($productPhotos as $productPhoto)
            {
                array_push($photos, env("APP_URL")."api/getPhoto/".$productPhoto->image);

            }
            $product["productPhoto"] = $photos;
            $product["productPrice"] = $orderProduct->unit_price;
            $product["productDiscount"] = $order->resturant->discount;
            $product["productQuantity"] = $orderProduct->quantity;
            $product["productTotal"] = $orderProduct->total;
            $product["productComment"] = $orderProduct->comment;
            array_push($orderProductsArr,$product);
        }
        $response["products"] = $orderProductsArr;
        $orderUser = $order->user;
        $user["userId"] = $orderUser->id;
        $user["userName"] = $orderUser->name;
        $user["userPhoneNumber"] = $orderUser->phone_number;

        $response["user"] = $user;
        $orderAddress = $order->address;
        $address["addressName"] = $orderAddress->address;
        $address["addressLat"] = $orderAddress->lat;
        $address["addressLng"] = $orderAddress->long;
        $address["addressBuilding"] = $orderAddress->building;
        $address["addressFloor"] = $orderAddress->floor;
        $address["addressFlat"] = $orderAddress->flat;
        $response["address"] = $address;

        return $response;
    }

    public function mergeInto(Order $order)
    {
        $this->orderedItems()->update(['order_id' => $order->id]);
        $this->carts()->update(['table_id' => $order->table_id,'order_id' => $order->id]);
        $this->status = self::STATUS_CLOSED;
        $this->saveWithoutEvents();
    }

    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function() use ($options) {
            return $this->save($options);
        });
    }
}
