<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard.dashboard', ['pageTitle' => 'Dashboard']);
})->middleware(['auth'])->name('dashboard');

Route::resource('attendance', AttendanceController::class);

Route::middleware(['auth'])->group(function() {
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/request', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    Route::delete('/leave/{id}', [LeaveController::class, 'destroy'])->name('leave.cancel');
    Route::view('/leave/holidays', 'Leave.holiday')->name('leave.holidays');

});

Route::get('/policy', function () {
    return view('policy'); // make sure you have resources/views/policy.blade.php
})->name('policy');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    
});

require __DIR__.'/auth.php';
