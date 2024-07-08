<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\StudentCourseController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Student\registerController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[CourseController::class, 'all_courses'])->name('welcome');

Route::get('trainers/{id}',[TrainerController::class, 'all_trainers'])->name('trainers');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth' ,'role:Student']], function () {

    Route::get('/welcome',[CourseController::class, 'all_courses'])->name('welcome');
});

Route::group(['middleware' => ['auth', 'check.username']], function () {
    
    ///...............Admin Dashboard.......................
    Route::resource('/categories', CategoryController::class);
    
    Route::resource('trainer', TrainerController::class);
    
    Route::resource('course', CourseController::class);
    
    Route::resource('student', StudentController::class);
    
    Route::resource('student_course', StudentCourseController::class);
    
    Route::resource('roles', RoleController::class);
    
    Route::resource('users', UserController::class);

    Route::resource('registerin', registerController::class);
    
});

//Forget password..........................................................................................
Route::get('forgot-password', function () {
    return view('auth.passwords.forgot');
})->name('password.request');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', function ($token) {
    return view('auth.reset', ['token' => $token]);
})->name('auth.password.reset');

Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');






