<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
            'email' => 'regex:/^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})?$/',
            'name' => 'regex:/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/',
            'text' => 'regex:/.{1,255}/',
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Please enter first name in format: nikola@gmail.com',
            'name.regex' => 'Please enter first name in format: Nikola',
            'text.regex' => 'Text is required, not longer than 255 characters',
        ];
    }
}
