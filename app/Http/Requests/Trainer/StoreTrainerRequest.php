<?php

namespace App\Http\Requests\Trainer;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainerRequest extends FormRequest
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
            'educational_level' => 'required|string',
            'gender' => 'required|string',
            'instagram' => 'required|string',
            'email' => 'required|email|unique:trainers',
            'phone' => 'required|string|unique:trainers',
            'certificate' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'identity_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'birth_date' => 'required|date',
            'about' => 'required|string',
        ];
    }
}
