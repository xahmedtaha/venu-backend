<?php

namespace App\Http\Requests\UserApi;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestValidationJsonResponse;
class EditCartItemRequest extends FormRequest
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
            "cart_item_id" => 'required|exists:ordered_items,id',
            "quantity" => 'required',
            "size_id" => 'required|exists:sizes,id',
            "sides.*.side_id" => 'exists:item_sides,id'
        ];
    }
}
