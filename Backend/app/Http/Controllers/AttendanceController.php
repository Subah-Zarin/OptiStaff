<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendances.
     */
    public function index(Request $request)
    {
        // Fetch all employees for the filter dropdown
        $employees = Employee::all();

        // Fetch attendances with employee relation, filter by date and employee if provided
        $attendances = Attendance::with('employee')
            ->when($request->date, fn($query) => $query->whereDate('date', $request->date))
            ->when($request->employee, fn($query) => $query->where('employee_id', $request->employee))
            ->paginate(10);

        // Return the attendance view
        return view('attendance', compact('attendances', 'employees'));
    }
}
