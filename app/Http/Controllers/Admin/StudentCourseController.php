<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Students;
use Illuminate\Http\Request;

use App\Models\Student_course;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StudentCourse\StoreStudentCourseRequest;
use App\Http\Requests\StudentCourse\UpdateStudentCourseRequest;
use App\Http\Requests\StudentCourse\registerStudentCourseRequest;


class StudentCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:  إدارة تسجيل الطلاب|الطلاب'])->only('index');
        $this->middleware(['permission:تسجيل طالب'])->only('store');
        $this->middleware(['permission:تعديل تسجيل الطالب'])->only('update');
        $this->middleware(['permission:حذف تسجيل الطالب'])->only(['destroy']);
    }

//========================================================================================================================

    public function index()
    {
        try {
            $StudentCourses = Student_course::all();
            $courses = Course::all();
            $students = Students::all();
            return view('Admin.student_course.index', compact('StudentCourses','courses','students'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to show all student"s course: ' . $e->getMessage());
        }
    }

//========================================================================================================================
public function create()
{
    try {
        $StudentCourses = Student_course::all();
        $courses = Course::all();
        $students = Students::all();
        return view('Admin.student_course.add' ,compact('StudentCourses','courses','students'));
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Unable to retrieve student"s course at this time. Please try again later.');
    }
}

//========================================================================================================================

public function store(StoreStudentCourseRequest $request)
{
    try {
        $validatedData = $request->validated();
        
        $course = Course::find($validatedData['course_id']);

        if ($validatedData['status'] == 'paid') {
            if ($course->number_of_students_paid >= $course->number_of_students) {
                $course->status = 'completed';
                $course->save();
                return redirect()->route('student_course.index')->with('error', 'No available seats for this course.');
            }

            $course->number_of_students_paid += 1;
            // إذا أصبح العدد مكتمل بعد التحديث، تغيير حالة الكورس إلى مكتمل
            if ($course->number_of_students_paid >= $course->number_of_students) {
                $course->status = 'completed';
            }
            $course->save();
        }
    
        Student_course::create([
            'student_id' => $validatedData['student_id'],
            'course_id' => $validatedData['course_id'],
            'status' => $validatedData['status'],
        ]);

        session()->flash('Add', 'Add successfully');
        return redirect()->route('student_course.index')->with('Add', 'student"s course created successfully'); 

    } catch (\Exception $e) {
        return redirect()->route('student_course.index')->with('error', 'Failed to create student"s course: ' . $e->getMessage());
    }
}

//========================================================================================================================

public function edit($id)
{
    $StudentCourses = Student_course::findOrFail($id);
    $courses = Course::all();
    $students = Students::all();
    return view('Admin.student_course.edit', compact('StudentCourses','courses','students'));
}

//========================================================================================================================
public function update(UpdateStudentCourseRequest $request, Student_course $studentCourse)
{
    try {
        $validatedData = $request->validated();

        $course = Course::find($validatedData['course_id']);

   
        if ($studentCourse->status == 'paid' && $validatedData['status'] == 'unpaid') {
            if ($course->number_of_students_paid > 0) {
                $course->number_of_students_paid -= 1;

                if ($course->number_of_students_paid < $course->number_of_students) {
                    $course->status = 'available';
                }
            }
        } elseif ($studentCourse->status == 'unpaid' && $validatedData['status'] == 'paid') {
            if ($course->number_of_students_paid < $course->number_of_students) {
                $course->number_of_students_paid += 1;

                if ($course->number_of_students_paid >= $course->number_of_students) {
                    $course->status = 'completed';
                }
            } else {
                return redirect()->route('student_course.index')->with('error', 'No available seats for this course.');
            }
        }

        $course->save();

        $studentCourse->student_id = $validatedData['student_id'];
        $studentCourse->course_id = $validatedData['course_id'];
        $studentCourse->status = $validatedData['status'];
        $studentCourse->save();

        return redirect()->route('student_course.index')->with('edit', 'student\'s course updated successfully');
    } catch (\Exception $e) {
        return redirect()->route('student_course.index')->with('error', 'Failed to update student\'s course: ' . $e->getMessage());
    }
}



//========================================================================================================================

    public function destroy(Student_course $student_course)
    {
        try {

            $course = Course::find($student_course->course_id);

            if ($student_course->status == 'paid') {

                if ($course->status == 'completed') {
                    $course->number_of_students_paid -= 1;
                    $course->status = 'available';

                }else{
                    $course->number_of_students_paid -= 1;
                }

                $course->save();
            }

            $student_course->delete();

            return redirect()->route('student_course.index')->with('delete', 'student"s course deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('student_course.index')->with('error', 'Failed to delete student"s course : ' . $e->getMessage());
        }
    }

}
