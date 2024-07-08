<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Students;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/welcome';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'phone' => 'required|string|min:10|max:10|unique:students',
            'email' => 'required|email|unique:students',
            'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'birth_date' => 'required|date',
            'educational_level' => 'required|string',
            'gender' => 'required|string',
            'location' => 'required|string',
            'password' => 'required|string|min:8',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            $personal_photo = $this->storeFile($data['personal_photo']);
    
            Students::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'personal_photo' => $personal_photo,
                'birth_date' => $data['birth_date'],
                'educational_level' => $data['educational_level'],
                'gender' => $data['gender'],
                'location' => $data['location'],
                'password' => Hash::make($data['password']),
            ]);
                
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => ["Student"],
            ]);

            $studentRole = Role::firstOrCreate(['name' => 'Student']);
            $user->assignRole($studentRole);

            return $user;
    
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Failed to register: ' . $e->getMessage());
        }
    }
    

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
}
