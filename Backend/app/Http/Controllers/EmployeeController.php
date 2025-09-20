<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Show the employee Blade page with search, sort, and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sortField', 'id');
        $sortDirection = $request->input('sortDirection', 'asc');

        // Fetch employees (exclude admin if needed)
        $employees = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('role', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends([
                'search' => $search,
                'sortField' => $sortField,
                'sortDirection' => $sortDirection,
            ]);

        return view('employee.Employee', compact('employees', 'search', 'sortField', 'sortDirection'));
    }
    public function show($id)
{
    // Find the employee by ID, or fail with a 404 if not found
    $employee = User::findOrFail($id);

    // Return a new blade view to display the employee details
    return view('employee.show', compact('employee'));
}

    /**
     * Return JSON of all non-admin users for API.
     */
   public function apiIndex()
{
    // Fetch all users except admin
    $employees = User::where('role', '!=', 'admin')->get();

    return response()->json([
        'success' => true,
        'data' => $employees
    ]);
}

}
