<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // your users table is employees
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // Display attendance list
    public function index(Request $request)
    {
        $employees = User::all();

        $attendances = Attendance::with('employee')
            ->when($request->date, fn($query) => $query->whereDate('date', $request->date))
            ->when($request->employee, fn($query) => $query->where('employee_id', $request->employee))
            ->paginate(10);

       $pageTitle = "Attendance";
    return view('attendance', compact('attendances', 'employees', 'pageTitle'));
    }

    // Show form to create attendance
    public function create()
    {
        $employees = User::all();
        return view('attendance.create', compact('employees'));
    }

    // Store new attendance
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave',
            'notes' => 'nullable|string',
        ]);

        Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance added successfully.');
    }

    // Show form to edit attendance
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = User::all();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    // Update attendance
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave',
            'notes' => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }

    // Delete attendance
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
         return redirect()->route('attendance.index')->with('success', 'Attendance deleted.');
    }
}
