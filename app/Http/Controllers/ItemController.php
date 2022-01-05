<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Resturant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view products'])->only(['index']);
        $this->middleware(['permission:add products'])->only(['create','store']);
        $this->middleware(['permission:update products'])->only(['edit','update']);
        $this->middleware(['permission:delete products'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Resturant $resturant = null)
    {
        if($resturant!=null)
            $items = $resturant->items;

        else
            $items = Auth::user()->getItems();

        return view('item.all',compact('items','resturant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Resturant $selectedResturant = null)
    {
        $resturants = Auth::user()->getResturants();
        $item = new Item();
        return view('item.form',compact('resturants','item','selectedResturant'));
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
        $validationRules = [
            "name_ar"=>"required",
            "name_en"=> "required",
            "resturant_id"=>"required|exists:resturants,id",
            "price_before"=>"required",
            // "price_after"=>"required",
            // "discount"=>"required",
            // "offer"=>"required",
            "description_ar"=>"required",
            "description_en"=>"required",
        ];
        for($i=0;$i<count($request->images);$i++)
        {
            $validationRules["images.".$i] = 'image|mimes:jpeg,bmp,png';
        }
        $validator = Validator::make($request->all(),$validationRules,[

        ]);

        if($validator->fails())
        {
            return Redirect::back()->withInput(Input::all())->withErrors($validator->errors());
        }

        $resturant = Resturant::find($request->resturant_id);

        $price_after = $request->price_before +( $request->price_before * ($resturant->offer / 100));
        $attributes = $request->except('images');
        $attributes["price_after"] = $price_after;
        $item = Item::create($attributes);
        $item->sizes()->create([
            'name_ar'=>$item->name_ar,
            'name_en'=>$item->name_en,
            'resturant_id'=>$item->resturant_id,
            'price_before'=>$item->price_before,
            'price_after' => $item->price_after,
            'description_ar'=>$item->description_ar,
            'description_en'=>$item->description_en,
        ]);
        if($request->images)
        foreach($request->images as $image)
        {
            $imageFile = $image->store('public/product_images');
            $item->images()->create(['image'=>$imageFile]);
            $file_path = storage_path('app/'.$imageFile);
            $this->compress($file_path, $file_path);
        }
        $item_id = $item->id;
        $item->attachToResturantBranches();
        return redirect()->route('resturants.items.index',$resturant->id)->with('add','success');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
        $selectedResturant = $item->resturant;
        $resturants = Resturant::all();
        return view('item.form',compact('resturants','selectedResturant','item'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
        $validationRules = [
            "name_ar"=>"required",
            "name_en"=> "required",
            "resturant_id"=>"required|exists:resturants,id",
            "price_before"=>"required",
            // "price_after"=>"required",
            // "discount"=>"required",
            // "offer"=>"required",
            "description_ar"=>"required",
            "description_en"=>"required",
            "images.*" => 'image|mimes:jpeg,bmp,png'
        ];

        $validator = Validator::make($request->all(),$validationRules,[

        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $resturant = Resturant::find($request->resturant_id);

        $price_after = $request->price_before +( $request->price_before * ($resturant->offer / 100));
        $attributes = $request->except('images');
        $attributes["price_after"] = $price_after;
        if($attributes['side_slots'] == null)
            unset($attributes['side_slots']);

        $item->update($attributes);
        if($request->has('images'))
        {
            foreach($request->images as $image)
            {
                $imageFile = $image->store('public/product_images');
                $item->images()->create(['image'=>$imageFile]);
                $file_path = storage_path('app/'.$imageFile);
                $this->compress($file_path, $file_path);
            }
        }
        return bacK()->withSuccess('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return back();
    }

    public function compress($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 50);             
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 4);
        }
        return $compress_image;
    }
}
