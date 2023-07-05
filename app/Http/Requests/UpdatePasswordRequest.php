<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password' => 'regex:/[a-z0-9]{4,15}/',
            'new_password' => 'same:password_confirm|regex:/[a-z0-9]{4,15}/',
            'password_confirm' => 'same:new_password|regex:/[a-z0-9]{4,15}/',
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.regex' => 'Please enter password between 4 and 15 characters',
            'new_password.regex' => 'Please enter password between 4 and 15 characters',
            'new_password.same' => "New passwords doesn't match",
            'password_confirm.same' => "New passwords doesn't match",
            'password_confirm.regex' => 'Please enter password between 4 and 15 characters'
        ];
    }
}
