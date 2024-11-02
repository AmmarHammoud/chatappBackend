<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'nullable|string',
            'media' => 'nullable|file',
            'media_type' => 'nullable|string|in:image,video,audio,pdf',
        ];
    }
}

