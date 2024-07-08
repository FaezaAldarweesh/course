<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:40|regex:/^[a-zA-Z\s\p{Arabic}]+$/u',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'string',
        ];
    }
    public function messages(): array
    {
        return [
            'name.regex' => 'The category name field must contain letters only.',
        ];
    }
}
