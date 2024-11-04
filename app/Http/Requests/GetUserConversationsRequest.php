<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUserConversationsRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check(); // التحقق من تسجيل الدخول
    }

    public function rules()
    {
        return [
            'offset' => 'integer|min:0', 
        ];
    }
}
