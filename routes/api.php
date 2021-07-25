<?php

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

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/instructors', [InstructorController::class, 'index']);
Route::get('/profile', [UserController::class, 'show']);

Route::middleware(['auth:sanctum', 'admin'])->group(
    function () {
        Route::get('/all_appointments', [AppointmentController::class, 'all']);
        Route::post('/instructors', [InstructorController::class, 'store']);
        Route::put('/instructors/{id}', [InstructorController::class, 'update']);
        Route::delete('/instructors/{id}', [InstructorController::class, 'destroy']);
    }
);
Route::middleware('auth')->group(
    function () {
        Route::get('/logout', [UserController::class, 'logout']);
    }
);
Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
        Route::get('/appointments/', [AppointmentController::class, 'index']);
        Route::put('/profile', [UserController::class, 'update']);
        Route::get('/date', [AppointmentController::class, 'date']);
    }
);
Route::middleware(['auth:sanctum', 'super_admin'])->group(
    function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::put('/users', [UserController::class, 'updateRole']);
    }
);
