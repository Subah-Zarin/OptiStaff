<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceLockController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');


Route::get('/attendance-report', [AttendanceController::class, 'report'])->name('attendance.report');

// New Attendance Locking Routes (Admin Only)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/attendance/lock', [AttendanceLockController::class, 'index'])->name('attendance.lock.index');
    Route::post('/attendance/lock', [AttendanceLockController::class, 'store'])->name('attendance.lock.store');
    Route::delete('/attendance/unlock', [AttendanceLockController::class, 'destroy'])->name('attendance.lock.destroy');
});

Route::resource('attendance', AttendanceController::class);

Route::middleware(['auth'])->group(function() {
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/request', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    Route::delete('/leave/{id}', [LeaveController::class, 'destroy'])->name('leave.cancel');
    Route::get('/leave/holidays', [HolidayController::class, 'employeeIndex'])->name('leave.holidays');


});

// Admin view to see all leave requests
Route::middleware(['auth'])->group(function () {
    Route::get('/leave/leave_approvals', [LeaveController::class, 'approvals'])->name('leave.approvals');
    Route::put('/leave/approve/{id}', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::put('/leave/reject/{id}', [LeaveController::class, 'reject'])->name('leave.reject');
     Route::get('/leave_status', [LeaveController::class, 'status'])->name('leave.leave_status');
});

Route::get('/policy', function () {
    return view('policy');
})->name('policy');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
});

// Admin dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // AI HR Chatbot Routes - ADD THESE 2 LINES
    Route::get('/hr-chat', [ChatController::class, 'index'])->name('hr.chat');
    Route::post('/hr-chat/ask', [ChatController::class, 'ask'])->name('hr.chat.ask');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');
    Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');
    Route::put('/holidays/{holiday}', [HolidayController::class, 'update'])->name('holidays.update');
    Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');
});



require __DIR__.'/auth.php';