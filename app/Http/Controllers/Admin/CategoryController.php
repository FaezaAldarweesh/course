<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Models\Category;
use App\Http\Controllers\Controller;

use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:إدارةالتصنيفات|التصنيفات'])->only('index');
        $this->middleware(['permission:اضافة تصنيف'])->only('store');
        $this->middleware(['permission:تعديل تصنيف'])->only('update');
        $this->middleware(['permission:حذف تصنيف'])->only(['destroy']);
    }

//========================================================================================================================

    public function index()
    {
        try {
            $categories = Category::all();
            return view('Admin.category.index', compact('categories'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to show all categories: ' . $th->getMessage());
        }
    }

//========================================================================================================================

public function create()
{
    try {
        return view('Admin.category.add');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Unable to retrieve category at this time. Please try again later.');
    }
}

//========================================================================================================================

    public function store(StoreCategoryRequest $request)
    {

        try {
            $validatedData = $request->validated();

            $photoName = $this->storeFile($validatedData['photo']);
        
            Category::create([
                'name' => $validatedData['name'],
                'photo' => $photoName,
                'description' => $validatedData['description'],
            ]);

            session()->flash('Add', 'Add Susseccfully');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to Add category: ' . $th->getMessage());
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
    
//=======================================================================================================================

public function edit($id)
{
    $Category = Category::find($id);
    return view('Admin.category.edit', compact('Category'));
}

//========================================================================================================================

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('photo')) {
                $photoName = $this->storeFile($validatedData['photo']);

                if ($category->photo && file_exists(public_path('images') . '/' . $category->photo)) {
                    unlink(public_path('images') . '/' . $category->photo);
                    File::delete(public_path('images/' . $category->photo));

                }

                $category->photo = $photoName;
            }

            $category->name = $validatedData['name'];
            $category->description = $validatedData['description'];
            $category->save();

            session()->flash('edit', 'ُEdit Susseccfully');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to Edit category: ' . $th->getMessage());
        }
    }

//========================================================================================================================

    public function destroy(Category $category)
    {
        try {
            if ($category->photo && file_exists(public_path('images') . '/' . $category->photo)) {
                unlink(public_path('images') . '/' . $category->photo);
                File::delete(public_path('images/' . $category->photo));
                $category->delete();
            }

            session()->flash('delete', 'Delete Susseccfully');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

//========================================================================================================================

}
