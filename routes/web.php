<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}/delete', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::put('/students/{student}/restore', [StudentController::class, 'restore'])->name('students.restore');
    
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::put('/teachers', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}/delete', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    Route::put('/teachers/{teacher}/restore', [TeacherController::class, 'restore'])->name('teachers.restore');
    
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses', [CourseController::class, 'update'])->name('courses.update');
    Route::put('/courses/{course}/deactivate', [CourseController::class, 'deactivate'])->name('courses.deactivate');
    Route::put('/courses/{course}/restore', [CourseController::class, 'restore'])->name('courses.restore');
    Route::delete('/courses/{course}/delete', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::put('/enrollments', [EnrollmentController::class, 'update'])->name('enrollments.update');
    Route::delete('/enrollments/{enrollment}/delete', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/students/export', [ReportController::class, 'exportStudentsCSV'])->name('reports.students.export');
    Route::get('/reports/courses/export', [ReportController::class, 'exportCoursesCSV'])->name('reports.courses.export');
    Route::get('/reports/teachers/export', [ReportController::class, 'exportTeachersCSV'])->name('reports.teachers.export');
});

require __DIR__ . '/auth.php';
