<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class GetDetailProductRequest extends FormRequest
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
            'id' => 'required|exists:products'
        ];
    }
}
