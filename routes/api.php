<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas API para Cursos
Route::apiResource('courses', CourseController::class);

// Rutas API para Estudiantes
Route::apiResource('students', StudentController::class);
