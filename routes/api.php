<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user(); register
// });
Route::post('login', [UserController::class, 'loginUser'])->name('login');
Route::post('register', [UserController::class, 'store']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('courses', [CourseController::class, 'show']);
    Route::get('user-profile', [UserController::class, 'show']);
    Route::post('courses/students', [TeacherController::class, 'addStudent']);
    Route::put('courses/marks', [TeacherController::class, 'editMark']);
    Route::post('courses/tasks', [TeacherController::class, 'addTask']);
    Route::post('roles', [AdminController::class, 'store']);
    Route::get('students', [AdminController::class, 'show']);
    Route::get('students/{id}/classes', [CourseController::class, 'showStudentClass']);
    Route::get('teachers/{id}/classes', [CourseController::class, 'showTeacherClass']);
});
