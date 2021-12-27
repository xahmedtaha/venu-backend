<?php

namespace App\Http\Requests\UserApi;

use App\Traits\RequestValidationJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    use RequestValidationJsonResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_id' => 'required|exists:items,id',
            'size_id' => 'required|exists:sizes,id',
            'sides.*' => 'exists:item_sides,id',
            'quantity' => 'required'
        ];
    }
}
