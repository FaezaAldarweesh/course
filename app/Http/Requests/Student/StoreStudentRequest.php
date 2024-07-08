<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string|min:10|max:10|unique:students',
            'email' => 'required|email|unique:students',
            'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'birth_date' => 'required|date',
            'educational_level' => 'required|string',
            'gender' => 'required|string',
            'location' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }
}
