<?php
// app/Http/Requests/GetMessagesRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetMessagesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'offset' => 'integer|min:0', // التأكد من أن القيمة غير سالبة
        ];
    }

    public function authorize()
    {
        return true; // يجب أن ترجع true للسماح بالطلب
    }
}

