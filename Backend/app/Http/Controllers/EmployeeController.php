<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        
        $employees = User::select('id', 'name', 'email', 'role', 'created_at', 'updated_at')->get();

  
        return view('employee.Employee', compact('employees'));
    }
}
