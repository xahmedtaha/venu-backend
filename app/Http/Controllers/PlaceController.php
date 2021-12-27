<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view places'])->only(['index']);
        $this->middleware(['permission:add places'])->only(['create','store']);
        $this->middleware(['permission:update places'])->only(['edit','update']);
    }
    
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function index()
    {
        $places = Place::all();
        return view('place.all',compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('place.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
           "name_ar" => 'required', 
           "name_en" => 'required', 
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $place = Place::create($request->all());
        return redirect()->route('place.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        return view('place.edit',compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        $validator = Validator::make($request->all(),
        [
           "name_ar" => 'required', 
           "name_en" => 'required', 
        ]);
        $place->update($request->all());
        return redirect()->route('place.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->cities()->delete();
        $place->delete();
        return redirect()->route('place.index');

    }

    public function get(Place $place)
    {
        $cities = $place->cities;
        if(Auth::guard('web')->check())
        {
            $display_name = Auth::user()->lang=='ar'?'name_ar':'name_en';
            foreach($cities as $city)
            {
                $city["display_name"] = $city->$display_name;
            }
        }
        return response()->json($cities);
    }
}
