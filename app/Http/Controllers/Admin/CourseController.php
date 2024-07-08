<?php

namespace App\Http\Controllers\Admin;
use Exception;

use App\Models\Course;
use App\Models\Trainer;
use App\Models\Category;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use function Laravel\Prompts\select;

use Illuminate\Support\Facades\File;
use App\Http\Requests\Courses\StoreCoursesRequest;

use App\Http\Requests\Courses\UpdateCoursesRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission: إدارةالكورسات|الكورسات'])->only('index');
        $this->middleware(['permission:اضافة كورس'])->only('store');
        $this->middleware(['permission:تعديل كورس'])->only('update');
        $this->middleware(['permission:حذف كورس'])->only(['destroy']);
    }

//========================================================================================================================

    public function index()
    {
        try {
            $courses = Course::all();
            $categories = Category::all();
            $trainers = Trainer::all();
            return view('Admin.course.index', compact('courses','categories','trainers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to show all courses: ' . $e->getMessage());
        }
    }

//========================================================================================================================
public function create()
{
    try {
        $categories = Category::all();
        $trainers = Trainer::all();
        return view('Admin.course.add' , compact ('categories','trainers'));
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Unable to retrieve course at this time. Please try again later.');
    }
}

//========================================================================================================================

public function store(StoreCoursesRequest $request)
{
    try {
        $validatedData = $request->validated();

        $photoName = $this->storeFile($validatedData['photo']);
    
        Course::create([
            'category_id' => $validatedData['category_id'],
            'trainer_id' => $validatedData['trainer_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'age' => $validatedData['age'],
            'number_of_students' => $validatedData['number_of_students'],
            'number_of_students_paid' => 0,
            'price' => $validatedData['price'],
            'number_of_sessions' => $validatedData['number_of_sessions'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'time' => $validatedData['time'],
            'photo' => $photoName,
            'status' => 'available',
        ]);


        session()->flash('Add', 'Add successfully');
        return redirect()->route('course.index')->with('Add', 'Course created successfully'); 

    } catch (\Exception $e) {
        return redirect()->route('course.index')->with('error', 'Failed to create course: ' . $e->getMessage());
    }
}


//========================================================================================================================

public function storeFile($file)
    {
        
        // Get the original file name
        $originalName = $file->getClientOriginalName();
        
        // Check for double extensions in the file name
        if (preg_match('/\.[^.]+\./', $originalName)) {
            throw new HttpResponseException(response()->json(['message' => trans('general.notAllowedAction')], 403));
        }
            
        $fileName =  time() .Str::random(32) ;//. '.' .'jpg'
     

        // Save the Image and get the path within the storage disk
        try {
            $file->move(public_path('images'), $fileName);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => $e->getMessage()], 500));
        }

        return  $fileName;
       
    }
    
//========================================================================================================================

public function edit($id)
{
    $course = Course::find($id);
    $categories = Category::all();
    $trainers = Trainer::all();
    return view('Admin.course.edit', compact('course','categories','trainers'));
}

//========================================================================================================================
public function update(UpdateCoursesRequest $request, Course $course)
{
    try {
        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            $photoName = $this->storeFile($validatedData['photo']);

            if ($course->photo && file_exists(public_path('images') . '/' . $course->photo)) {
                unlink(public_path('images') . '/' . $course->photo);
                File::delete(public_path('images/' . $course->photo));
            }

            $course->photo = $photoName;
        }

        $number_of_students_paid = Course::select('number_of_students_paid')->get();

        $course->category_id = $validatedData['category_id'];
        $course->trainer_id = $validatedData['trainer_id'];
        $course->name = $validatedData['name'];
        $course->description = $validatedData['description'];
        $course->age = $validatedData['age'];
        $course->number_of_students = $validatedData['number_of_students'];
        $course->number_of_students_paid = $number_of_students_paid;
        $course->price = $validatedData['price'];
        $course->number_of_sessions = $validatedData['number_of_sessions'];
        $course->start_date = $validatedData['start_date'];
        $course->end_date = $validatedData['end_date'];
        $course->time = $validatedData['time'];
        $course->status = $validatedData['status'];
       
        $course->save();

        return redirect()->route('course.index')->with('success', 'Course updated successfully');
    } catch (\Exception $e) {
        return redirect()->route('course.index')->with('error', 'Failed to update course: ' . $e->getMessage());
    }
}


//========================================================================================================================

    public function destroy(Course $course)
    {
        try {
            if ($course->photo && file_exists(public_path('images') . '/' . $course->photo)) {
                unlink(public_path('images') . '/' . $course->photo);
                File::delete(public_path('images/' . $course->photo));
                $course->delete();
            }
        
            session()->flash('delete', 'delete succsesfuly');
            return redirect()->route('course.index')->with('delete', 'course deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('course.index')->with('error', 'Failed to delete course: ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function all_courses()
    {
        try {
            $courses = Course::all();
            $categories = Category::all();
            $trainers = Trainer::all();
            return view('welcome', compact('courses','categories','trainers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to show all courses: ' . $e->getMessage());
        }
    }

}
