<?php

namespace App\Http\Controllers\Api\WaiterApi;

use Illuminate\Http\Request;
use App\Models\Waiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use Kreait\Firebase\Messaging\Http\Request\SendMessage;
use Google\Auth\OAuth2;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\WaiterApi\LoginRequest;
use App\Models\Branch;

class LoginController extends ApiBaseController
{
    //
    public function Login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $fcm_token = $request->fcm_token;

        $waiter = Waiter::where('email',$email)->first();
        if($waiter!=null)
        {
            if(Hash::check($password, $waiter->password))
            {
                
                $waiter->update(['fcm_token'=>$fcm_token]);
                $token = Auth::guard('waiters')->login($waiter);
                $waiter->token = $token;
                $waiter->load('branch');                
                return $this->sendResponse($waiter);
            }
            else
            {
                return $this->sendErrorMessage('wrong email or password');
            }
        }
        else
        {
            return $this->sendErrorMessage('wrong email or password');
        }
    }

    public function getPhoto($folder,$name)
    {
          
        $imagePath = base_path('storage/app/'.$folder.'/'.$name);
        return response()->file($imagePath);
    }

    
    public function Sendfeedback(Request $request)
    {
        return $this->sendResponse('success');  
    }
    public function Logout(Request $request)
    {
        Auth::user()->token()->delete();
        return $this->sendResponse("success");
    }
}
