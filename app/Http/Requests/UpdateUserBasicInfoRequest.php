<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserBasicInfoRequest extends FormRequest
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
            'first_name' => 'regex:/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/',
            'last_name' => 'regex:/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/',
            'role_name' => 'required',
            'image' => 'nullable|sometimes|image|max:1024',
            'username' => [
                'regex:/[a-z0-9]{4,15}/',
                Rule::unique('users', 'username')->ignore($this->id)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Please enter first name in format: nikola@gmail.com',
            'first_name.regex' => 'Please enter first name in format: Nikola',
            'last_name.regex' => 'Please enter first name in format: Kralj',
            'username.regex' => 'Username should contain only letters and numbers, between 4 and 15 characters',
            'username.unique' => 'This username already exists',
            'password.regex' => 'Please enter password between 4 and 15 characters',
            'image.image' => 'Image must be in .jpg, .jpeg, .png format',
            'image.max' => 'Image must be max 1MB big',
        ];
    }
}
