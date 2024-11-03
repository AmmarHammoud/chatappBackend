<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteReactionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // يمكنك تعديل هذا حسب سياسة الوصول لديك
    }

    public function rules()
    {
        return [
            'message_id' => 'required|integer|exists:messages,id',
            'reaction_type' => 'required|string|in:like,love,haha,sad,angry', // تأكد من تحديد الأنواع المسموح بها
        ];
    }
}

