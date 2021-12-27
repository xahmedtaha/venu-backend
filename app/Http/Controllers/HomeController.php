<?php

namespace App\Http\Controllers;
use App\Http\Controllers\DB;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Symfony\Component\Mime\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $androidUsersNum = User::where('platform','Android')->get()->count();
        $iosUsersNum     = User::where('platform','Ios')->get()->count();
        $resturants      = Auth::user()->resturants;
        $OrdrersNum      = 0;
        $TodayOrdrersNum = 0;
        foreach($resturants as $resturant)
        {  
            $orders     = Order::where('resturant_id',$resturant->id)->get();
            $numOrders  = $orders->count();
            $OrdrersNum = $OrdrersNum+ $numOrders;            
        }

        foreach($resturants as $resturant)
        {  
            $orders     = Order::where('resturant_id',$resturant->id)->whereDate('created_at', \DB::raw('CURDATE()'))->get();
            $numOrders  = $orders->count();
            $TodayOrdrersNum = $TodayOrdrersNum+ $numOrders;            
        }
                

        return view('welcome',compact('androidUsersNum','iosUsersNum','OrdrersNum','TodayOrdrersNum'));
    }

    public function testFirebase(Request $request)
    {
        $serviceAccount = ServiceAccount::fromJsonFile(base_path('app/Http/Controllers/foodbook-1e57c-532dba3bb098.json'));
        $firebase = (new Factory())->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://foodbook-1e57c.firebaseio.com/')->create();
        $database = $firebase->getDatabase();
        $fcm = $firebase->getMessaging();
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
        $notification = Notification::create("Test Topic messaging","Test Topic messaging");
        
        $message = CloudMessage::withTarget('topic','foodbook_ar')
                    ->withData(["data"=>json_encode($data)]);
        
        $fcm->send($message);
        return "hello";
    }
}
