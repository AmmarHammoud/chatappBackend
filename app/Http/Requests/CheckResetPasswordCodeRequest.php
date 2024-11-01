<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckResetPasswordCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string',
        ];
    }
}
