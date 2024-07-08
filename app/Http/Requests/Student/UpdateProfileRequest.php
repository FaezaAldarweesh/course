<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $email = $this->student->email->id ?? '';
        $phone = $this->student->phone->id ?? '';
    
        return [
            'name' => 'string',
            'phone' => 'string|min:10|max:10|' . $phone,
            'email' => 'email' . $email,
            'birth_date' => 'date',
            'educational_level' => 'string',
            'gender' => 'string',
            'location' => 'string',
            'password' => 'string|min:8',
        ];
    }
}
