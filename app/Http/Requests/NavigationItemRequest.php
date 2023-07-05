<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NavigationItemRequest extends FormRequest
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
            'name_id' => 'required',
            'order' => 'required|integer|min:0',
            'route' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name_id.required' => 'You must enter name',
            'order.required' => 'You must enter order number',
            'order.integer' => 'Order must be number',
            'order.min' => "Order number can't be negative number",
            'route.required' => "You must set route for navigation item",
        ];
    }
}
