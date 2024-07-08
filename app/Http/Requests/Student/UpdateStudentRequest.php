<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $email = $this->email->id ?? '';
        $phone = $this->phone->id ?? '';
    
        return [
            'name' => 'string',
            'phone' => 'string|min:10|max:10|' .$phone,
            'email' => 'email' .$email,
            'personal_photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'birth_date' => 'date',
            'educational_level' => 'string',
            'gender' => 'string',
            'location' => 'string',
        ];
    }
    
}
