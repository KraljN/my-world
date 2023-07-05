<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'comment_text' => 'required|max:200',
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }
    public function messages(): array
    {
        return [
            'comment_text.required' => "Comment text can't be empty",
        ];
    }
}
