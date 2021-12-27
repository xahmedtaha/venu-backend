<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Resturant $resturant)
    {
        $branches = $resturant->branches;
        return view('branch.all',compact('resturant','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Resturant $resturant)
    {
        $branch = new Branch();
        return view('branch.form',compact('branch','resturant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resturant $resturant)
    {
        $validator = Validator::make($request->all(),[
            'name_ar' => 'required',
            'name_en' => 'required',
            'lat'     => 'required',
            'lng'     => 'required',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $branch = $resturant->branches()->create($data);
        $branch->attachToResturantItems();
        return redirect()->route('resturants.branches.index',$resturant->id)->withSuccess('');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Resturant $resturant,Branch $branch)
    {
        return view('branch.form',compact('branch','resturant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Resturant $resturant ,Branch $branch)
    {
        $validator = Validator::make($request->all(),[
            'name_ar' => 'required',
            'name_en' => 'required',
            'lat'     => 'required',
            'lng'     => 'required',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        if($request->password)
        {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $branch->update($data);
        }
        else
        {
            $data = $request->except('password');
            $branch->update($data);
        }

        return redirect()->route('resturants.branches.index',$resturant->id)->withSuccess('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch, Resturant $resturant)
    {
        $branch->delete();
        return redirect()->route('resturants.branches.index',$resturant->id)->withSuccess('');
    }
}
