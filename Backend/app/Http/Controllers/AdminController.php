<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin_dashboard'); // resources/views/admin/admin_dashboard.blade.php
    }
}
