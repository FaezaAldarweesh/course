<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursesRequest extends FormRequest
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
       // $courseId = $this->course->id ?? '';
    
        return [
            'category_id' => 'exists:categories,id',
            'trainer_id' => 'exists:trainers,id',
            'name' => 'string|unique:courses,name,'.$this->course->id ,
            'description' => 'string',
            'age' => 'numeric|min:1',
            'number_of_students' => 'numeric|min:1',
            'price' => 'numeric|min:1',
            'number_of_sessions' => 'numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'time' => 'string',
             'photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'string',
        ];
    }
    
}
