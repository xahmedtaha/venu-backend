<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Resturant;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


use Auth;
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view orders'])->only(['index','getOrderDetailsAjax']);
        $this->middleware(['permission:delete orders'])->only(['destroy']);
        $this->middleware(['permission:change orders status'])->only(['changeOrderStatusAjax']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ordersIndex(Request $request)
    {
        $orders = Order::where('status','>','2')->paginate(50);
        return view('order.index',compact('orders'));
    }

    public function index()
    {
        // $orders = Order::where('status','<=','2')->orderBy('updated_at','DESC')->get();
        return view('order.all');
    }

    public function getOrdersViewsAjax(Request $request)
    {
        $orders = Order::where('status','<=','2')->orderBy('updated_at','DESC')->get();
        return view('order.rows',compact('orders'));
    }
    public function getOrdersModalsAjax(Request $request)
    {
        $orders = Order::where('status','<=','2')->orderBy('updated_at','DESC')->get();
        return view('order.modals',compact('orders'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
    }

    
    public function getOrderDetailsAjax(Order $order)
    {
        $response = Order::getOrderAsJson($order,Auth::user()->lang);
        return response()->json($response);
    }

    public function changeOrderStatusAjax(Request $request,Order $order)
    {
        $validator = Validator::make($request->all(),[
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(["message"=>"status is required"],400);
        }
        $status = $request->status;
        if($status<$order->status)
        {
            return response()->json(["message"=>"unavailable status"],400);
        }
        else
        {
            $order->changeStatus($status);
            return response()->json(["message"=>"success"]);
        }
    }

    
}
