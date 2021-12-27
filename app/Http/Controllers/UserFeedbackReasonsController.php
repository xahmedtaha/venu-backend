<?php

namespace App\Http\Controllers;

use App\Models\UserFeedbackReason;
use App\Models\UserFeedbackReasons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserFeedbackReasonsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view feedback reasons'])->only(['index']);
        $this->middleware(['permission:add feedback reasons'])->only(['create','store']);
        $this->middleware(['permission:update feedback reasons'])->only(['edit','update']);
        $this->middleware(['permission:delete feedback reasons'])->only(['destroy']);
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userFeedbackReasons = UserFeedbackReason::all();
        return view('reason.all',compact('userFeedbackReasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('reason.add');
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
           "name_ar" => 'required' 
        ],
        [
           "name_ar.required" => 'name is required'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        UserFeedbackReason::create($request->all());
        
        return redirect()->route('userFeedbackReason.index')->with('add','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserFeedbackReason  $userFeedbackReason
     * @return \Illuminate\Http\Response
     */
    public function show(UserFeedbackReason $userFeedbackReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserFeedbackReason  $userFeedbackReason
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFeedbackReason $userFeedbackReason)
    {
        //
        
        return view('reason.edit',compact('userFeedbackReason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserFeedbackReason  $userFeedbackReason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFeedbackReason $userFeedbackReason)
    {
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
        $userFeedbackReason->update($request->except(["display_name"]));
        return redirect()->route('userFeedbackReason.index')->with('update','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserFeedbackReason  $userFeedbackReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFeedbackReason $userFeedbackReason)
    {
        //
        $userFeedbackReason->delete();
        return back();
    }
}
