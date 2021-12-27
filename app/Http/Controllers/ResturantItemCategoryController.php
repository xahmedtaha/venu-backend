<?php

namespace App\Http\Controllers;

use App\Models\Resturant;
use App\Models\ResturantItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResturantItemCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view product categories'])->only(['index']);
        $this->middleware(['permission:add product categories'])->only(['create','store']);
        $this->middleware(['permission:update product categories'])->only(['edit','update']);
        $this->middleware(['permission:delete product categories'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Resturant $resturant = null)
    {
        if($resturant==null)
            $categories = ResturantItemCategory::all();
        else
            $categories = $resturant->itemCategories;

        return view('resturantProductCategory.all',compact('categories','resturant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Resturant $resturant)
    {
        return view('resturantProductCategory.add',compact('resturant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'resturant_id' => 'required|exists:resturants,id',
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        if($validator->fails())
            return back()->withErrors($validator->errors());

        $itemCategory = ResturantItemCategory::create($request->all());

        return redirect()->route('itemCategories.index',$request->resturant_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResturntItemCategory  $resturntItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ResturantItemCategory $resturntItemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResturantItemCategory  $resturntItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Resturant $resturant,ResturantItemCategory $itemCategory)
    {
//        dd($itemCategory);
        return view('resturantProductCategory.edit',compact('itemCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResturantProductCategory  $resturantItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Resturant $resturant , ResturantItemCategory $itemCategory)
    {
        $validator = Validator::make($request->all(),[
            'name_ar' => 'required',
            'name_en' => 'required',
        ]);

        if($validator->fails())
            return back()->withErrors($validator->errors());

        $itemCategory->update($request->all());

        return redirect()->route('itemCategories.index',$resturant->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResturantItemCategory  $resturantItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resturant $resturant,ResturantItemCategory $itemCategory)
    {
        $itemCategory->delete();
        return back();
    }
}
