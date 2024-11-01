<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

             'message_id' => 'required|exists:messages,id',
                'status' => 'required|in:sent,delivered,seen',
            ];


    }
}
