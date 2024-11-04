<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'nullable|string|max:1000', // النص
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mp3|max:10240', // صورة، فيديو، أو صوت
            'media_type' => 'nullable|string|in:image,video,audio', // نوع الوسائط
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();

            // تحقق من وجود media أو content
            if (empty($data['message']) && empty($data['media'])) {
                $validator->errors()->add('content', 'The message or media must be present.');
            }

            // تحقق من تحديد media_type إذا كان media موجودًا
            if (!empty($data['media']) && empty($data['media_type'])) {
                $validator->errors()->add('media_type', 'The media_type must be specified when media is present.');
            }
        });
    }
    public function authorize(): bool
    {
        return true;
    }

}

