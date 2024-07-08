<?php

namespace App\Http\Requests\Trainer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainerRequest extends FormRequest
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
            'educational_level' => 'string',
            'gender' => 'string|in:male,female',
            'instagram' => 'string',
            'email' => 'email' .$email,
            'phone' => 'string' .$phone,
            'certificate' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'personal_photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'identity_photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'birth_date' => 'date',
            'about' => 'string',
        ];
    }
    
}
