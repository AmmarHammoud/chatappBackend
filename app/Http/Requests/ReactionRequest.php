<?php



namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'message_id' => 'required|exists:messages,id',
            'reaction_type' => 'required|string|in:like,dislike,love', // يمكنك تخصيص الأنواع هنا
        ];
    }
}
