<?php

namespace App\Http\Controllers\Student;

use App\Models\Course;
use App\Models\Students;
use Illuminate\Http\Request;

use App\Models\Student_course;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StudentCourse\StoreStudentCourseRequest;
use App\Http\Requests\StudentCourse\UpdateStudentCourseRequest;
use App\Http\Requests\StudentCourse\registerStudentCourseRequest;


class registerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:الكورسات المسجلة|الملف الشخصي'])->only('index');
        $this->middleware(['permission:تسجيل كورس'])->only('store');
        $this->middleware(['permission:حذف تسجيل'])->only(['destroy']);
    }

//========================================================================================================================

public function index()
{
    try {
        $courses = Course::all();
        $students = Students::all();

        $email_user = Auth::user()->email;
        $student = Students::select('id')->where('email', $email_user)->first();
        
        if ($student) {
            $StudentCourses = Student_course::where('student_id', $student->id)->get();
            return view('student.register.index', compact('StudentCourses', 'courses', 'students'));
        } else {
            return redirect()->back()->with('error', 'Student not found.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to show all student\'s courses: ' . $e->getMessage());
    }
}


//========================================================================================================================

public function create()
{
    try {

        $courses = Course::all();
        $email_user = Auth::user()->email;
        $students = Students::select('id' , 'name')->where('email', $email_user)->first();

        return view('student.register.add' ,compact('courses','students'));
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Unable to retrieve student"s course at this time. Please try again later.');
    }
}

//========================================================================================================================
public function store(registerStudentCourseRequest $request)
{
    try {
        $validatedData = $request->validated();
        
        $course = Course::find($validatedData['course_id']);

        $status = 'unpaid';
    
        Student_course::create([
            'student_id' => $validatedData['student_id'],
            'course_id' => $validatedData['course_id'],
            'status' => $status,
        ]);

        session()->flash('Add', 'Add successfully');
        return redirect()->route('registerin.index')->with('Add', 'student"s course created successfully'); 

    } catch (\Exception $e) {
        return redirect()->route('registerin.index')->with('error', 'Failed to create student"s course: ' . $e->getMessage());
    }
}
//========================================================================================================================

    public function destroy($id)
    {
        try {

            $student_course = Student_course::findOrFail($id);
            $student_course->delete();

            return redirect()->route('registerin.index')->with('delete', 'student"s course deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('registerin.index')->with('error', 'Failed to delete student"s course : ' . $e->getMessage());
        }
    }

}
