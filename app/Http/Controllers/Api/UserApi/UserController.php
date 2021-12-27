<?php

namespace App\Http\Controllers\Api\UserApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use App\Models\OAuthAccessToken;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\User;
use Illuminate\Validation\Rule;
class UserController extends ApiBaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "phone"=>"required|size:11",
            "name"=>"required",
            "email"=>"required|email|unique:users,email",
            "fcm_token"=>"required",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());

        $fcm_token = $request->fcm_token;
        $lang = $request->header('accept-language')??'en';
        $platform = $request->header('platform')??'android';
        $phone = $request->phone;
        $name = $request->name;
        $email = $request->email;

        $user = User::where('phone',$request->phone)->first();
        if($user)
        {
            return $this->sendErrorMessage('This phone is already registered');
        }

        $user = User::create(
            [
                "phone" => $phone,
                "name" => $name,
                "email" => $email,
                "firebase_token"=>$fcm_token,
                "lang"=> $lang,
                "platform" => $platform
            ]);

        return $this->sendPhoneLoginResponse($user);
    }

    public function phoneLogin(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "phone"=>"required|size:11",
            "fcm_token"=>"required",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());

        $fcm_token = $request->fcm_token;
        $lang = $request->header('accept-language')??'en';
        $platform = $request->header('platform','android');

        $user = User::where('phone',$request->phone)->first();
        if($user)
        {
            $user->update([
                'firebase_token' => $fcm_token,
                'lang' => $lang,
                'platform' => $platform
            ]);

            return $this->sendPhoneLoginResponse($user);
        }
        else
        {
            return $this->sendErrorMessage('Phone is not registered');
        }
    }

    public function sendPhoneLoginResponse(User $user)
    {
        $hashCode = $this->generateVerificationCodes($user);

        return $this->sendResponse(["hashKey"=>$hashCode]);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $fcm_token = $request->fcm_token;

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email'    => 'required',
            'fcm_token' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->getMessages());
        }
        $user = User::where('email',$email)->first();
        if($user!=null)
        {
            if(Hash::check($password, $user->password))
            {
                OAuthAccessToken::where('user_id',$user->id)->where("name",'user_app')->delete();
                $token = $user->createToken('user_app')->accessToken;
                $user->update(['firebase_token'=>$fcm_token]);
                $response = $this->getUserAsJSON($user);
                $response["token"]= $token;
                return $this->sendResponse($response);
            }
        }
        else
        {
            return $this->sendErrorMessage(" برجاء التأكد من كلمة السر او الايميل");
        }
    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "name"=>"required",
            "fcm_token"=>"required",
            "email"=>"required_with:googleToken",
            "googleToken" => "required_without:facebookToken",
            "facebookToken" => "required_without:googleToken",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());

        $name = $request->name;
        $fcm_token = $request->fcm_token;
        $address = $request->address;
        $googleToken = $request->googleToken;
        $facebookToken = $request->facebookToken;
        $email = null;
        $isRegistered = false;
        if($googleToken)
        {
            $email = $request->email;
            $user = User::where('google_token',$googleToken)->first();
            if($user)
                $isRegistered=true;
        }
        else
        {
            $user = User::where('facebook_token',$facebookToken)->first();
            if($user)
                $isRegistered=true;
        }
        if(!$isRegistered)
        {
            $lang = $request->header('accept-language');
            $user = User::create([
                    "name" => $name,
                    "firebase_token" => $fcm_token ,
                    "google_token" => $googleToken ,
                    "facebook_token" => $facebookToken ,
                    "email" => $email ,
                    "lang"=> $lang,
                    "password" => Hash::make($name)
                ]);
            // dd($user);
            if($address!=null)
            {
                $user->addresses()->create([
                    "address"=>$address["name"],
                    "lat"=>$address["lat"],
                    "long"=>$address["lng"],
                    "building"=>$address["buildingNumber"],
                    "floor"=>$address["floor"],
                    "flat"=>$address["flatNumber"],
                ]);
            }
        }
        //delete the old token if found
        $user->update(["firebase_token"=>$fcm_token]);
        OAuthAccessToken::where('user_id',$user->id)->where("name",'user_app')->delete();
        $token = $user->createToken('user_app')->accessToken;

        $response = $this->getUserAsJSON($user);
        $response["token"] = $token;

        return $this->sendResponse($response);
    }

    public function changeLanguage(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
        [
            "lang"=>["required",Rule::in(['ar','en'])],
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());

        $lang = $request->lang;
        $user = Auth::user();
        $user->update(['lang'=>$lang]);

        // OAuthAccessToken::where('user_id',$user->id)->where('name','user_app')->delete();
        // $token = $user->createToken('user_app')->accessToken;

        $response = $this->getUserAsJSON($user);
        $response["token"]= "";

        return $this->sendResponse($response);
    }

    public function changeUserData(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
        [
            "name"=>"required",
            "fcm_token"=>"required",
        ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());

        $name = $request->name;
        $password = $request->password;
        $fcm_token = $request->fcm_token;
        $email = $request->email;
        $address = $request->address;
        $updateArr["name"] = $name;
        if($email)
            $updateArr["email"] = $email;
        if($password)
            $updateArr["password"] = $password;

        $user->update($updateArr);
        if($address!=null)
        {
            $user->addresses()->delete();
            $user->addresses()->create([
                "address"=>$address["name"],
                "lat"=>$address["lat"],
                "long"=>$address["lng"],
                "building"=>$address["buildingNumber"],
                "floor"=>$address["floor"],
                "flat"=>$address["flatNumber"],
            ]);
        }

        // OAuthAccessToken::where('user_id',$user->id)->where('name','user_app')->delete();
        // $token = $user->createToken('user_app')->accessToken;

        $response = $this->getUserAsJSON($user);
        $response["token"]= "";

        return $this->sendResponse($response);
    }

    public function verifyPhone(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            "hashKey" => "required",
            "pincode" => "required"
        ]);
        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());

        $hashKey = $request->hashKey;
        $pincode = $request->pincode;
        $user = User::where('hash_code',$hashKey)->where('pin_code',$pincode)->first();
        if($user)
        {
            $user->update(
                [
                    "verified_at"=>date('Y-m-d h:i:s')
                ]);

            // OAuthAccessToken::where('user_id',$user->id)->where("name",'user_app')->delete();
            // $token = $user->createToken('user_app')->accessToken;

            $token = Auth::guard('users')->login($user);
            $user->token = $token;
            // $response = $this->getUserAsJSON($user);

            return $this->sendResponse($user);
        }
        else
        {
            return $this->sendErrorMessage('wrong pincode');
        }

    }

    public function getProfile(Request $request)
    {
        return $this->sendResponse(Auth::user());
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
//                "phone"=>["size:11",Rule::unique('users','phone')->ignore($user->id)],
                "email"=>["email",Rule::unique('users','email')->ignore($user->id)],
                "name" => 'required'
            ]);

        if($validator->fails())
            return $this->sendError($validator->errors()->getMessages());

        $user->update($request->all());

        return $this->sendResponse($user);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->update(['firebase_token'=>null]);

        return $this->sendResponse(["message"=>"success"]);

    }

    public function getUserAsJSON($user)
    {
        $response["id"] = $user->id;
        $response["name"]= $user->name;
        $response["email"]= $user->email;
        $response["lang"] = $user->lang;
        $response["phone_number"] = $user->phone_number;
        $address = $user->addresses()->first();
        $response["address"]["name"] = null ;
        $response["address"]["lat"] = null ;
        $response["address"]["lng"] = null ;
        $response["address"]["buildingNumber"] = null ;
        $response["address"]["floor"] = null ;
        $response["address"]["flatNumber"] = null ;
        if($address)
        {
            $response["address"]["name"] = $address->address ;
            $response["address"]["lat"] = $address->lat ;
            $response["address"]["lng"] = $address->long ;
            $response["address"]["buildingNumber"] = $address->building ;
            $response["address"]["floor"] = $address->floor ;
            $response["address"]["flatNumber"] = $address->flat ;
        }

        return $response;
    }

    /**
     * Generates the user verification hashcode and pincode
     * @param User $user
     * @return string
     */
    private function generateVerificationCodes(User $user): string
    {
        $pinCode = '1234';
        $hashCode = $this->generateRandomString();
        if($user->phone != config('app.test_user_phone')) {
            $pinCode = $this->generateRandomNumber(4);
        }
        else {
            $pinCode = 1234;
        }
        $user->update([
            'hash_code' => $hashCode,
            'verified_at' => null,
            'pin_code' => $pinCode,
        ]);
        User::sendVerificationSMS($user->phone, $pinCode);
        return $hashCode;
    }
}
