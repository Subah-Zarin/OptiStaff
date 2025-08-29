<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // resources/views/admin/dashboard.blade.php
    }
}
