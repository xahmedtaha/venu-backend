<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Models\Size;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view subproducts'])->only(['index']);
        $this->middleware(['permission:add subproducts'])->only(['create','store']);
        $this->middleware(['permission:update subproducts'])->only(['edit','update']);
        $this->middleware(['permission:delete subproducts'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Item $item)
    {
        return view('sizes.all',compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Item $item)
    {
        $size = new Size();
        return view('sizes.form',compact('item','size'));
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
            "item_id"=>"required|exists:items,id",
            "price_before"=>"required",
            // "price_after"=>"required",
            // "discount"=>"required",
            // "offer"=>"required",
            'images.*' => 'image|mimes:jpeg,bmp,png',
            "description_ar"=>"required",
            "description_en"=>"required",
        ];
        // for($i=0;$i<count($request->images);$i++)
        // {
        //     $validationRules["images.".$i] = 'image|mimes:jpeg,bmp,png';
        // }
        $validator = Validator::make($request->all(),$validationRules);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        } 

        $resturant = $item->resturant;

        $price_after = $request->price_before +( $request->price_before * ($resturant->offer / 100));
        $attributes = $request->except('images');
        $attributes["price_after"] = $price_after;
        $attributes["resturant_id"] = $resturant->id;
        $size = Size::create($attributes);
        if($request->images)
        {
            foreach($request->images as $image)
            {
                $imageFile = $image->store('sub_product_images');
                $size->images()->create(['image'=>$imageFile]);
            }
        }
        return redirect()->route('sizes.index',$item->id)->withSuccess('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item,Size $size)
    {
        return view('sizes.form',compact('size','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Item $item,Size $size)
    {
        $validationRules = [
            "name_ar"=>"required",
            "name_en"=> "required",
            "price_before"=>"required",
            "description_ar"=>"required",
            "description_en"=>"required",
        ];
        $validator = Validator::make($request->all(),$validationRules,[

        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $resturant = $item->resturant;

        $price_after = $request->price_before +( $request->price_before * ($resturant->offer / 100));
        $attributes = $request->except('images');
        $attributes["price_after"] = $price_after;
        $size->update($attributes);
        if($request->hasFile('images'))
        {
            foreach($request->images as $image)
            {
                $imageFile = $image->store('sub_product_images');
                $size->images()->create(['image'=>$imageFile]);
            }
        }
        return redirect()->route('sizes.index',$item->id)->withSuccess('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {
        $size->delete();
    }
}
