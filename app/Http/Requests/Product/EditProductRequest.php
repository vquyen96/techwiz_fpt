<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    public function authorize()
    {
        $this->merge(['id' => $this->route('id')]);
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
            'id' => 'required|exists:products',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'game_id' => 'required|integer',
            'delivery_method' => 'required|integer',
            'buy_now_price' => 'required|numeric|between:1,9999999999999,99',
            'expiration' => 'required|integer',
            'images' => [
                'present',
                'nullable',
                'string',
                'regex:/[0-9\|]*$/',
            ],
        ];
    }
}
