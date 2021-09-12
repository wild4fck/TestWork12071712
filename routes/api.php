<?php

use App\Http\Controllers\Education\CoursesController;
use App\Http\Controllers\Education\CoursesTeachersController;
use App\Http\Controllers\Education\StudentsController;
use App\Http\Controllers\Education\TeachersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/** Студенты  */
Route::group([
    'prefix' => 'students',
], function () {
    Route::get('/', [StudentsController::class, 'getStudents']);
    Route::post('/add', [StudentsController::class, 'add']);
    Route::post('/edit', [StudentsController::class, 'edit']);
    Route::post('/delete', [StudentsController::class, 'delete']);
});

/** Преподаватели  */
Route::group([
    'prefix' => 'teachers',
], function () {
    Route::get('/', [TeachersController::class, 'getTeachers']);
    Route::post('/add', [TeachersController::class, 'add']);
    Route::post('/edit', [TeachersController::class, 'edit']);
    Route::post('/delete', [TeachersController::class, 'delete']);
});

/** Курсы  */
Route::group([
    'prefix' => 'courses',
], function () {
    Route::get('/', [CoursesController::class, 'getCourses']);
    Route::get('/getWithTeachers', [CoursesController::class, 'getWithTeachers']);
    Route::post('/add', [CoursesController::class, 'add']);
    Route::post('/edit', [CoursesController::class, 'edit']);
    Route::post('/delete', [CoursesController::class, 'delete']);
});
