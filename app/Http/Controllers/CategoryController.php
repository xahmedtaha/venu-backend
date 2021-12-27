<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view categories'])->only(['index']);
        $this->middleware(['permission:add categories'])->only(['create','store']);
        $this->middleware(['permission:update categories'])->only(['edit','update']);
        $this->middleware(['permission:delete categories'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('category.all',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->middleware('permission:add categories');
        return view('category.add');
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
        $this->middleware('permission:add categories');

        $validator = Validator::make($request->all(),
        [
           "name_ar" => 'required' 
        ],
        [
           "name_ar.required" => 'name is required'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        Category::create($request->all());
        
        return back()->with('add','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        $this->middleware('permission:update categories');

        return view('category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->middleware('permission:update categories');

        $validator = Validator::make($request->all(),
        [
           "name_ar" => 'required' 
        ],
        [
           "name_ar.required" => 'name is required'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $category->update($request->except(["display_name"]));
        return back()->with('update','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $this->middleware('permission:delete categories');

        $category->delete();
        return back();
    }
}
