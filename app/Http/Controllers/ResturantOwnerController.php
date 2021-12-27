<?php

namespace App\Http\Controllers;

use App\Models\ResturantOwner;
use Illuminate\Http\Request;
use App\Models\Resturant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ResturantOwnerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view resturant owners'])->only(['index']);
        $this->middleware(['permission:add resturant owners'])->only(['create','store']);
        $this->middleware(['permission:update resturant owners'])->only(['edit','update']);
        $this->middleware(['permission:delete resturant owners'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $resturantOwners = ResturantOwner::all();
        return view('resturantOwner.all',compact('resturantOwners'));
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
        return view('resturantOwner.add',compact('resturants'));
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
        $validator = Validator::make($request->all(),
        [
           "name_ar" => 'required' ,
           "name_en" => 'required' ,
           "resturant_id" => 'required|exists:resturants,id' ,
           "email" => 'required|unique:resturant_owners',
           "password" => 'required',
           "confirm_password" => 'required'
        ],
        [
           
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        ResturantOwner::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'resturant_id' => $request->resturant_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return back()->with('add','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResturantOwner  $resturantOwner
     * @return \Illuminate\Http\Response
     */
    public function show(ResturantOwner $resturantOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResturantOwner  $resturantOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(ResturantOwner $resturantOwner)
    {
        //
        $resturants = Resturant::all();
        return view('resturantOwner.edit',compact('resturantOwner','resturants'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResturantOwner  $resturantOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResturantOwner $resturantOwner)
    {
        //
        $validator = Validator::make($request->all(),
        [
           "name_ar" => 'required' ,
           "name_en" => 'required' ,
           "resturant_id" => 'required|exists:resturants,id' ,
           "email" => 'required|unique:resturant_owners',
           
        ],
        [
           
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $resturantOwner->update($request->only(['name_ar','name_en','resturant_id','email']));
        if($request->password!=null && $request->password==$request->confirm_password)
        {
            $resturantOwner->update(["password"=>Hash::make($request->password)]);
        }
        return back()->with('update','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResturantOwner  $resturantOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResturantOwner $resturantOwner)
    {
        //
        $resturantOwner->delete();
        return back();
    }
}
