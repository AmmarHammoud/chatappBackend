<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

                'type' => 'required|in:text,image,video',
                'content' => 'required_if:type,text|string',
                'media' => 'required_if:type,image,video|file|mimes:jpeg,png,jpg,gif,mp4|max:2048', // يجب أن تكون الوسائط متوافقة حسب النوع
            

        ];
    }
}
