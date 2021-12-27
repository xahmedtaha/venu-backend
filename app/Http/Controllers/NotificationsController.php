<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Resturant;
use App\Enums\NotificationTypes;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:send notification messages']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $resturants = Resturant::all();
        return view('messages.add',compact('resturants'));
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

        $validator = Validator::make($request->all(),[
            'title_ar' => 'required',
            'title_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $notification = Notification::create(
            [
                'user_id' => 0,
                'type' => $request->resturant_id?NotificationTypes::RESTAURANT_OFFER_CUSTOMER:NotificationTypes::ADMIN_TO_CUSTOMER,
                'sent_by' => Auth::user()->id,
                'title_ar' => $request->title_ar ,
                'title_en' => $request->title_en ,
                'description_ar' => $request->description_ar ,
                'description_en' => $request->description_en  ,
                'resturant_id' => $request->resturant_id
            ]);

        $notification->send($request->resturant_id);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function show(Notifications $notifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function edit(Notifications $notifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notifications $notifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notifications $notifications)
    {
        //
    }
}
