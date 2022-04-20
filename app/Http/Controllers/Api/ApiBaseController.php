<?php

namespace App\Http\Controllers\Api;

use App\Traits\RequestValidationJsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiBaseController extends BaseController
{
    use RequestValidationJsonResponse;
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sendResponse($result, $code = 200)
    {
        return response()->json($result, $code);
    }

    public function sendErrorMessage($errorMessage, $code = 400)
    {
        return response()->json(["errors" => $errorMessage, "message" => "failed"], $code);
    }

    public function sendError($errors, $code = 400)
    {
        return response()->json(["message" => "failed", "errors" => $errors], $code);
    }

    public function getImage($name)
    {
//        $imagePath = base_path('uploads/images/'.$name);
//        return response()->file($imagePath);
    }

    function generateRandomString($length = 10)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateRandomNumber($length = 10)
    {
        $characters       = '0123456789';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
