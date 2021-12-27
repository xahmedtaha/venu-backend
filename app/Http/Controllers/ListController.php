<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\ListItems;
use App\Models\Lists;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ListController extends Controller
{
    public function index(Resturant $resturant)
    {
        $lists = $resturant->itemLists;
        return view('lists.all',compact('lists','resturant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Resturant $resturant)
    {
        $list  = new Lists();
        $items = $resturant->items;
        return view('lists.form',compact('list','items','resturant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Resturant $resturant)
    {
       
        $validationRules = [
            "name_ar"=>"required",
            "name_en"=> "required",
        ];
        $validator = Validator::make($request->all(),$validationRules);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }     
        
        
        $list = Lists::create([
                            "name_ar"      => $request->name_ar,
                            "name_en"      => $request->name_en,
                            "resturant_id" => $resturant->id,
                            ]);

        $items = $request->input('items');
        foreach($items as $item)
        {
            // $list->items()->attach($item);
            ListItems::create([
                'item_id' => $item,
                'list_id' => $list->id
            ]);
        }

        return redirect()->route('lists.index',$resturant->id)->withSuccess('success');
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show( )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ItemSide  $itemSide
     * @return \Illuminate\Http\Response
     */
    public function edit( Resturant $resturant, $list)
    {
        $list  = Lists::find($list);
        $items = $resturant->items;
        return view('lists.form',compact('list','items','resturant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Resturant $resturant, $list)
    { 
        $validationRules = [
            "name_ar"=>"required",
            "name_en"=> "required",
        ];
        $validator = Validator::make($request->all(),$validationRules);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $arr = [
                "name_ar"      => $request->name_ar,
                "name_en"      => $request->name_en,
                "resturant_id" => $resturant->id,
              ];
        $list = Lists::find($list);
        $list->update($arr);

        $items = $request->input('items');
        foreach($items as $item)
        {
        $list->items()->sync($item);
        }

        return redirect()->route('lists.index',$resturant->id)->withSuccess('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resturant $resturant ,$list)
    {   
        Lists::find($list)->delete();
        return back();
    }
}
