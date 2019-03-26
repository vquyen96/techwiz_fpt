<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class ReadNotificationRequest extends FormRequest
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
            'id' => 'required|exists:notifications'
        ];
    }
}
