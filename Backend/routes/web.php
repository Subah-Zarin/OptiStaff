<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');


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

Route::get('/home', function () {
    return view('home');
})->name('home');

// Admin dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/admin_dashboard', function () {
        return view('admin.admin_dashboard');
    })->name('admin.dashboard');
});


require __DIR__.'/auth.php';