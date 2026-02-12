<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Show the employee Blade page with search, sort, and pagination.
     */
    public function index(Request $request)
{
    $query = User::query()->where('role', '!=', 'admin');

    // Search
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Sorting
    $sortBy = $request->get('sort', 'id');
    $direction = $request->get('direction', 'asc');
    $allowedSorts = ['id', 'name', 'email', 'created_at', 'updated_at', 'role'];
    if (!in_array($sortBy, $allowedSorts)) {
        $sortBy = 'id';
    }
    $query->orderBy($sortBy, $direction);

    // Pagination
    $employees = $query->paginate(10)->appends($request->all());

    return view('employee.Employee', compact('employees'));
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
 public function show(User $user)  // <<<<< Add this method
    {
        return view('employee.show', compact('user'));
    }
    public function download($id)
{
    $employee = User::findOrFail($id);

    $pdf = Pdf::loadView('employee.pdf', compact('employee')); // We'll create this view next

    return $pdf->download($employee->name . '_details.pdf');
}

}
