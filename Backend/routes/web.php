<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController; 
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {    
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard.dashboard'); 
})->middleware(['auth'])->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    // Attendance (all resource routes)
    Route::resource('attendance', AttendanceController::class);
});

require __DIR__.'/auth.php';
