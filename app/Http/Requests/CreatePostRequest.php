<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => 'required',
            'categories' => 'required|min:1',
            'tags' => 'required|min:1',
            'text' => 'required',
            'image' => 'nullable|sometimes|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'categories.required' => 'You must choose at least one category',
            'categories.min' => 'You must choose at least one category',
            'tags.required' => 'You must choose at least one tag',
            'tags.min' => 'You must choose at least one tag',
            'image.image' => 'Image must be in .jpg, .jpeg, .png format',
            'image.max' => 'Image must be max 1MB big',
        ];
    }
}
