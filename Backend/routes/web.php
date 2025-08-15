<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::middleware(['auth'])->group(function () {
    Route::resource('attendance', AttendanceController::class);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard'); 
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::resource('/attendance', AttendanceController::class);

});

require __DIR__.'/auth.php';
