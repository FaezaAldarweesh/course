<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursesRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:trainers,id',
            'name' => 'required|string|unique:courses',
            'description' => 'required|string',
            'age' => 'required|numeric|min:1',
            'number_of_students' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'number_of_sessions' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'time' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
