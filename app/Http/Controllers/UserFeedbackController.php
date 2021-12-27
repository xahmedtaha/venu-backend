<?php

namespace App\Http\Controllers;

use App\Models\UserFeedback;
use App\Models\UserFeedbackMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserFeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view view feedback messages']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = UserFeedback::all();
        return view('feedback.all',compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "feedback_id" => 'required|exists:user_feedbacks,id',
            "message" => 'required' 
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $feedback = UserFeedback::find($request->feedback_id);

        $feedback->messages()->create([
            "type" => UserFeedbackMessage::TYPE_ADMIN,
            "message" => $request->message 
        ]);
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserFeedback  $userFeedback
     * @return \Illuminate\Http\Response
     */
    public function show(UserFeedback $feedback)
    {
        return view('feedback.view',compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserFeedback  $userFeedback
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFeedback $userFeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserFeedback  $userFeedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFeedback $userFeedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserFeedback  $userFeedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFeedback $userFeedback)
    {
        //
    }
}
