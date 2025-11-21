<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController; // Tu controlador de cursos anterior
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Route;

// --- Rutas Públicas (Cualquiera puede entrar) ---
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Rutas Protegidas (Requieren Token válido) ---
Route::middleware('auth:sanctum')->name('api.')->group(function () {
    
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'userProfile']);

    // Tus Cursos (Ahora protegidos)
    // Solo usuarios logueados pueden ver la lista de cursos
    Route::apiResource('students', StudentController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('teachers', TeacherController::class);
    Route::apiResource('enrollments', EnrollmentController::class);
});