<?php

namespace App\Http\Controllers;

use App\Http\Resources\Orders as OrderResource;
use App\Http\Resources\Users as UserResource;
use App\Models\User;
use App\Models\Order;
use App\Models\Resturant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view reports']);
    }
    /*
    *
    */
    public function usersReport()
    {
        return view('reports.users');
    }

    public function getUsersData(Request $request)
    {
        return response()->json(UserResource::collection(User::all()));
    }

    public function ordersReport()
    {
        $resturants = Auth::user()->getResturants();
        return view('reports.orderForm',compact('resturants'));
    }

    public function getOrdersData(Request $request)
    {
        $orders = Order::where('resturant_id',$request->resturant_id)->latest()->get();
        return view('reports.orders',compact('orders'));
    }

    public function visitsReport()
    {
        return view('reports.visits');
    }

    public function getVisitsData(Request $request)
    {
        if(Auth::user()->level=="SuperAdmin")
            $resturants = Resturant::all();
        else {
            $resturants = Auth::user()->resturants;
        }


        $resturantVisits = array();
        foreach ($resturants as $resturant)
        {
            array_push($resturantVisits,["name"=>$resturant->name_ar,'count'=>$resturant->getVisitsCount()]);
        }
        $visitsCount = array_column($resturantVisits,'count');
        array_multisort($visitsCount,SORT_DESC,$resturantVisits);
        return response()->json($resturantVisits);
    }
}
