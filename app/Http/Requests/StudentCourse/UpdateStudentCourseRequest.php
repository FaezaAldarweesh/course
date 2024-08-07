<?php

namespace App\Http\Requests\StudentCourse;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentCourseRequest extends FormRequest
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
            'student_id' => 'exists:students,id',
            'course_id' => 'exists:courses,id',
            'status' => 'string',
        ];
    }
    
}
