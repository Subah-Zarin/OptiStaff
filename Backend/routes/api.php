<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get('/employees', [EmployeeController::class, 'apiIndex']);