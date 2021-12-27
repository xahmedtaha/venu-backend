<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait RequestValidationJsonResponse
{
    public function failedValidation(Validator $validator)
    {
        $this->sendError($validator->errors()->getMessages());
    }

    public function sendError($errors, $code = 400)
    {
        $errorMessage = "";
        foreach ($errors as $key=>$error) {
            $errorMessage = $errors[$key][0];
            break;
        }
        throw new HttpResponseException(response()->json(["message" => "failed", "errors" => $errorMessage], $code));
    }

}
