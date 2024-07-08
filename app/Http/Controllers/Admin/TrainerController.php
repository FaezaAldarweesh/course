<?php

namespace App\Http\Controllers\Admin;

use App\Models\Trainer;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Http\Requests\Trainer\StoreTrainerRequest;
use App\Http\Requests\Trainer\UpdateTrainerRequest;


class TrainerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission: إدارة المدربيين|المدربيين'])->only('index');
        $this->middleware(['permission:اضافة مدرب'])->only('store');
        $this->middleware(['permission:تعديل مدرب'])->only('update');
        $this->middleware(['permission:حذف مدرب'])->only(['destroy']);
    }

//========================================================================================================================

    public function index()
    {
        try {
            $trainers = Trainer::all();
            return view('Admin.trainer.index', compact('trainers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to show all Trainer: ' . $e->getMessage());
        }
    }

//========================================================================================================================
public function create()
{
    try {
        return view('Admin.trainer.add');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Unable to retrieve trainer at this time. Please try again later.');
    }
}

//========================================================================================================================

public function store(StoreTrainerRequest $request)
{
    try {
        $validatedData = $request->validated();

        $certificate = $this->storeFile($validatedData['certificate']);
        $personal_photo = $this->storeFile($validatedData['personal_photo']);
        $identity_photo = $this->storeFile($validatedData['identity_photo']);
    
        Trainer::create([
            'name' => $validatedData['name'],
            'educational_level' => $validatedData['educational_level'],
            'gender' => $validatedData['gender'],
            'instagram' => $validatedData['instagram'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'certificate' => $certificate,
            'personal_photo' => $personal_photo,
            'identity_photo' => $identity_photo,
            'birth_date' => $validatedData['birth_date'],
            'about' => $validatedData['about'],
        ]);

        session()->flash('Add', 'Add successfully');
        return redirect()->route('trainer.index')->with('Add', 'trainer created successfully'); 

    } catch (\Exception $e) {
        return redirect()->route('trainer.index')->with('error', 'Failed to create trainer: ' . $e->getMessage());
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
            $file->move(public_path('images/trainer'), $fileName);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => $e->getMessage()], 500));
        }

        return  $fileName;
       
    }
    
//========================================================================================================================

public function edit($id)
{
    $trainer = Trainer::find($id);
    return view('Admin.trainer.edit', compact('trainer'));
}

//========================================================================================================================
    public function update(UpdateTrainerRequest $request, Trainer $trainer)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('certificate')) {
                $certificate = $this->storeFile($validatedData['certificate']);

                if ($trainer->certificate && file_exists(public_path('images/trainer') . '/' . $trainer->certificate)) {
                    unlink(public_path('images/trainer') . '/' . $trainer->certificate);
                    File::delete(public_path('images/trainer/' . $trainer->certificate));

                }

                $trainer->certificate = $certificate;
            }
            //---------------------------------------------------------------------------------------------------
            if ($request->hasFile('personal_photo')) {
                $personal_photo = $this->storeFile($validatedData['personal_photo']);

                if ($trainer->personal_photo && file_exists(public_path('images/trainer') . '/' . $trainer->personal_photo)) {
                    unlink(public_path('images/trainer') . '/' . $trainer->personal_photo);
                    File::delete(public_path('images/trainer/' . $trainer->personal_photo));

                }

                $trainer->personal_photo = $personal_photo;
            }
            //---------------------------------------------------------------------------------------------------
            if ($request->hasFile('identity_photo')) {
                $identity_photo = $this->storeFile($validatedData['identity_photo']);

                if ($trainer->identity_photo && file_exists(public_path('images/trainer') . '/' . $trainer->identity_photo)) {
                    unlink(public_path('images/trainer') . '/' . $trainer->identity_photo);
                    File::delete(public_path('images/trainer/' . $trainer->identity_photo));

                }

                $trainer->identity_photo = $identity_photo;
            }

            $trainer->name = $validatedData['name'];
            $trainer->educational_level = $validatedData['educational_level'];
            $trainer->gender = $validatedData['gender'];
            $trainer->instagram = $validatedData['instagram'];
            $trainer->email = $validatedData['email'];
            $trainer->phone = $validatedData['phone'];
            $trainer->birth_date = $validatedData['birth_date'];
            $trainer->about = $validatedData['about'];
            $trainer->save();


            return redirect()->route('trainer.index', $trainer)->with('edit', 'trainer updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('trainer.index')->with('error', 'Failed to update trainer: ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function destroy(Trainer $trainer)
    {
        try {

            if ($trainer->certificate && file_exists(public_path('images/trainer') . '/' . $trainer->certificate)) {
                unlink(public_path('images/trainer') . '/' . $trainer->certificate);
                File::delete(public_path('images/trainer/' . $trainer->certificate));

            }

            if ($trainer->personal_photo && file_exists(public_path('images/trainer') . '/' . $trainer->personal_photo)) {
                unlink(public_path('images/trainer') . '/' . $trainer->personal_photo);
                File::delete(public_path('images/trainer/' . $trainer->personal_photo));

            }

            if ($trainer->identity_photo && file_exists(public_path('images/trainer') . '/' . $trainer->identity_photo)) {
                unlink(public_path('images/trainer') . '/' . $trainer->identity_photo);
                File::delete(public_path('images/trainer/' . $trainer->identity_photo));

            }

            $trainer->delete();
            session()->flash('delete', 'delete succsesfuly');
            return redirect()->route('trainer.index')->with('delete', 'trainer deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('trainer.index')->with('error', 'Failed to delete trainer: ' . $e->getMessage());
        }
    }

}
