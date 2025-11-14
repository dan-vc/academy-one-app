<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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


    Route::get('/teachers', function () {
        return view('teachers');
    })->name('teachers');
    Route::get('/courses', function () {
        return view('courses');
    })->name('courses');
    Route::get('/enrollments', function () {
        return view('enrollments');
    })->name('enrollments');
    Route::get('/reports', function () {
        return view('reports');
    })->name('reports');
});

require __DIR__ . '/auth.php';
