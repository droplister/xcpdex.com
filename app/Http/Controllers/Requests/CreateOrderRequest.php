<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateOrderRequest extends Request
{
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
            'source'        => 'required|alpha_num|min:26|max:35',
            'expiration'    => 'required|integer|min:1|max:8064',
            'get_asset'     => 'required|alpha_num|different:give_asset|min:3|max:20',
            'get_quantity'  => 'required|numeric',
            'give_asset'    => 'required|alpha_num|different:get_asset|min:3|max:20',
            'give_quantity' => 'required|numeric',
        ];
    }
}