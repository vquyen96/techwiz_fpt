<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class AddReviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'rating' => [
                'required',
                'integer',
                'between:1,5'
            ],
            'content' => 'required|string'
        ];
    }
}
