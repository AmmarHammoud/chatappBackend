<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConversationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
}
//2|CFl0mtRMngT865FLlzmxdpIKyUaAeCCJwYPUXASn65a72c1f
