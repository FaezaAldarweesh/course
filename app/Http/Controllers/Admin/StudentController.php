<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;

use App\Models\Students;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:  إدارةالطلاب|الطلاب'])->only('index');
        $this->middleware(['permission:اضافة طالب'])->only('store');
        $this->middleware(['permission:تعديل طالب'])->only('update');
        $this->middleware(['permission:حذف طالب'])->only(['destroy']);
    }

//========================================================================================================================

    public function index()
    {
        try {
            $students = Students::all();
            $courses = Course::all();
            return view('Admin.student.index', compact('students','courses'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to show all Students: ' . $e->getMessage());
        }
    }

//========================================================================================================================
public function create()
{
    try {
        $courses = Course::all();
        return view('Admin.student.add' ,compact('courses'));
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Unable to retrieve Students at this time. Please try again later.');
    }
}

//========================================================================================================================

public function store(StoreStudentRequest $request)
{
    try {
        $validatedData = $request->validated();

        $personal_photo = $this->storeFile($validatedData['personal_photo']);

        $student = Students::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'personal_photo' => $personal_photo,
            'birth_date' => $validatedData['birth_date'],
            'educational_level' => $validatedData['educational_level'],
            'gender' => $validatedData['gender'],
            'location' => $validatedData['location'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => ["Student"],
        ]);

        $studentRole = Role::where('name', 'Student')->first();

        if ($studentRole) {
            $user->assignRole($studentRole);
        }

        session()->flash('Add', 'Add successfully');
        return redirect()->route('student.index')->with('Add', 'Student created successfully');

    } catch (\Exception $e) {
        return redirect()->route('student.index')->with('error', 'Failed to create Student: ' . $e->getMessage());
    }
}



//========================================================================================================================

public function storeFile($file)
    {
        
        $originalName = $file->getClientOriginalName();
        
        if (preg_match('/\.[^.]+\./', $originalName)) {
            throw new HttpResponseException(response()->json(['message' => trans('general.notAllowedAction')], 403));
        }
            
        $fileName =  time() .Str::random(32) ;//. '.' .'jpg'
     
        try {
            $file->move(public_path('images/student'), $fileName);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => $e->getMessage()], 500));
        }

        return  $fileName;
       
    }
    
//========================================================================================================================

public function edit($id)
{
    $student = Students::find($id);
    $courses = Course::all();
    return view('Admin.student.edit', compact('student','courses'));
}

//========================================================================================================================
public function update(UpdateStudentRequest $request, Students $student)
{
    try {
        $validatedData = $request->validated();

        if ($request->hasFile('personal_photo')) {
            $personal_photo = $this->storeFile($validatedData['personal_photo']);

            if ($student->personal_photo && file_exists(public_path('images/student') . '/' . $student->personal_photo)) {
                unlink(public_path('images/student') . '/' . $student->personal_photo);
                File::delete(public_path('images/student/' . $student->personal_photo));
            }

            $student->personal_photo = $personal_photo;
        }

        $student->name = $validatedData['name'];
        $student->phone = $validatedData['phone'];
        $student->email = $validatedData['email'];
        $student->birth_date = $validatedData['birth_date'];
        $student->educational_level = $validatedData['educational_level'];
        $student->gender = $validatedData['gender'];
        $student->location = $validatedData['location'];
        $student->save();

        $user = User::where('email', $student->email)->first();

        if ($user) {
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'role' => ["Student"],
            ]);
        } else {
            return redirect()->route('student.index')->with('error', 'User not found');
        }

        return redirect()->route('student.index')->with('edit', 'Student updated successfully');
    } catch (\Exception $e) {
        return redirect()->route('student.index')->with('error', 'Failed to update student: ' . $e->getMessage());
    }
}

//========================================================================================================================

    public function destroy(Students $student)
    {
        try {

            if ($student->personal_photo && file_exists(public_path('images/student') . '/' . $student->personal_photo)) {
                unlink(public_path('images/student') . '/' . $student->personal_photo);
                File::delete(public_path('images/student/' . $student->personal_photo));

            }

            $student->delete();
            session()->flash('delete', 'delete succsesfuly');
            return redirect()->route('student.index')->with('delete', 'student deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('student.index')->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

}
