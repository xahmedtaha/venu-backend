<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view cities'])->only(['index']);
        $this->middleware(['permission:add cities'])->only(['create','store']);
        $this->middleware(['permission:update cities'])->only(['edit','update']);
        $this->middleware(['permission:delete cities'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return view('city.all',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Place $selectedPlace=null)
    {
        $places = Place::all();
        return view('city.add',compact('places','selectedPlace'));
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
        $place = Place::find($request->place_id);
        $place->cities()->create($request->all());
        return redirect()->route('city.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('city.edit',compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
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
        
        $city->update($request->all());
        return redirect()->route('city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('city.index');

    }
}
