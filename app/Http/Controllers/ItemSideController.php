<?php

namespace App\Http\Controllers;

use App\Models\ItemSide;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ItemSideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Item $item)
    {
        $sides = $item->sides;
        return view('itemSide.all',compact('sides','item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Item $item)
    {
        $side = new ItemSide();
        return view('itemSide.form',compact('item','side'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Item $item)
    {
        $validationRules = [
            "name_ar"=>"required",
            "name_en"=> "required",
            "weight"=>"required",
        ];
        $validator = Validator::make($request->all(),$validationRules);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $resturant = $item->resturant;

        if($request->weight > $item->side_slots)
        {
            return back()->withErrors('numer enterd bigger than item slots');
        }else
        $sides = ItemSide::create([
                            "name_ar"=>$request->name_ar,
                            "name_en"=> $request->name_en,
                            "weight"=>$request->weight,
                            "price"=> $request->price,
                            "item_id"=>$item->id,
                            ]);

        return redirect()->route('sides.index',$item->id)->withSuccess('success');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\ItemSide  $itemSide
     * @return \Illuminate\Http\Response
     */
    public function show(ItemSide $itemSide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ItemSide  $itemSide
     * @return \Illuminate\Http\Response
     */
    public function edit( $item, $itemSide)
    {
        $side = ItemSide::find($itemSide);
        return view('itemSide.form',compact('side'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ItemSide  $itemSide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Item $item, $itemSide)
    {
        $validationRules = [
            "name_ar"=>"required",
            "name_en"=> "required",
            "weight"=>"required",
        ];
        $validator = Validator::make($request->all(),$validationRules);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $resturant = $item->resturant;
        $sideRequest = [
            "name_ar"=>$request->name_ar,
            "name_en"=> $request->name_en,
            "weight"=>$request->weight,
            "price"=> $request->price,
            "item_id"=>$item->id,
        ];
        $side = ItemSide::find($itemSide);
        if($request->weight  > $item->side_slots)
        {
            return back()->withErrors('numer enterd bigger than item slots');
        }else
        $side->update($sideRequest);

        return redirect()->route('sides.index',$item->id)->withSuccess('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemSide  $itemSide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item, $itemSide)
    {
        $side = ItemSide::find($itemSide);
        $side->delete();
        return back();
    }
}
