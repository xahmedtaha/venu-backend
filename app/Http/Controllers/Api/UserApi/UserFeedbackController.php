<?php

namespace App\Http\Controllers\Api\UserApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\User;
use App\Models\UserFeedback;
use App\Models\UserFeedbackMessage;
use App\Models\UserFeedbackReason;
use Illuminate\Validation\Rule;
class UserFeedbackController extends ApiBaseController
{

    public function getFeedbackReasons(Request $request)
    {
        $nameAttr = 'name_'.$request->header('accept-language');
        $resturants = Auth::user()->resturants;
        $reasons = UserFeedbackReason::all();

        $response["resturants"] = array();
        foreach($resturants as $resturant)
        {
            $resturantObj["resturantId"]   = $resturant->id;
            $resturantObj["resturantName"] = $resturant->$nameAttr;
            array_push($response["resturants"],$resturantObj);
        }

        $response["reasons"] = array();
        foreach($reasons as $reason)
        {
            $reasonObj["reasonId"]   = $reason->id;
            $reasonObj["reasonName"] = $reason->$nameAttr;
            array_push($response["reasons"],$reasonObj);
        }

        return $this->sendResponse($response);
    }

    public function addFeedback(Request $request)   
    {
        $validator = Validator::make($request->all(),[
            "resturantId"=>"required|exists:resturants,id",
            "reasonId"=>"required|exists:user_feedback_reasons,id",
            "message"=>"required",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());
        
        $resturantId = $request->resturantId;
        $reasonId = $request->reasonId;
        $message = $request->message;

        $feedback = UserFeedback::create([
            "resturant_id"=>$resturantId,
            "reason_id"=>$reasonId,
            "user_id"=>Auth::user()->id
        ]);

        $feedback->messages()->create([
            "message" => $message,
            "type" => UserFeedbackMessage::TYPE_USER
        ]);

        $response["message"] = "success";
        return $this->sendResponse($response);
    }

    public function getFeedbacks(Request $request)
    {   
        $nameAttr = 'name_'.$request->header('accept-language');
        $user = Auth::user();
        $feedbacks = $user->feedbacks;
        $response["feedbacks"] = array();
        foreach($feedbacks as $feedback)
        {
            $feedbackObj["restaurantName"] = $feedback->resturant()->withTrashed()->first()->$nameAttr;
            $feedbackObj["reasonName"] = $feedback->reason()->withTrashed()->first()->$nameAttr;
            $feedbackObj["feedbackId"] = $feedback->id;

            array_push($response["feedbacks"],$feedbackObj);
        }

        return $this->sendResponse($response);
    }

    public function sendFeedback(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "feedbackMsg"=>"required",
            "feedbackId"=>"required|exists:user_feedbacks,id",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());
        $message = $request->feedbackMsg;
        $feedback = UserFeedback::find($request->feedbackId);
        $feedbackMessage = $feedback->messages()->create([
            "message" => $message,
            "type" => UserFeedbackMessage::TYPE_USER
        ]);
        $response["message"] = "success";
        return $this->sendResponse($response);
    }

    public function getFeedbackResponse(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "feedbackId"=>"required|exists:user_feedbacks,id",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());
            
        $feedback = UserFeedback::find($request->feedbackId);
        $feedbackMessages = $feedback->messages()->orderBy('created_at')->get();
        
        $response["feedbackMessages"] = array();
        foreach($feedbackMessages as $feedbackMessage)
        {
            $messageObj["feedbackTime"] = $feedbackMessage->created_at->format("Y-m-d H:i:s");
            $messageObj["feedbackMsg"] = $feedbackMessage->message;
            $messageObj["feebackType"] = $feedbackMessage->type;

            array_push($response["feedbackMessages"],$messageObj);
        }

        return $this->sendResponse($response);
    }
}
