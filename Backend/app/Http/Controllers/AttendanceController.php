<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // Display attendance list
    public function index(Request $request)
    {
        // Fetches only users with the 'user' role
        $employees = User::where('role', 'user')->get();

        $attendances = Attendance::with('user')
            ->when($request->date, fn($query) => $query->whereDate('date', $request->date))
            ->when($request->employee, fn($query) => $query->where('user_id', $request->employee))
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('attendance', compact('attendances', 'employees'));
    }

    // Show form to create attendance
    public function create()
    {
        // Fetches only users with the 'user' role for the dropdown
        $employees = User::where('role', 'user')->get();
        return view('attendance.create', compact('employees'));
    }

    // Store new attendance
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave', // 'Late' removed
            'notes' => 'nullable|string',
        ]);

        // Prevent attendance marking on a leave day
        $isOnLeave = Leave::where('user_id', $request->user_id)
            ->where('status', 'Approved')
            ->where('from_date', '<=', $request->date)
            ->where('to_date', '>=', $request->date)
            ->exists();

        if ($isOnLeave) {
            return redirect()->route('attendance.index')->with('error', 'Cannot mark attendance, the employee is on leave.');
        }


        Attendance::create($request->all());

        return redirect()->route('attendance.index')->with('success', 'Attendance added successfully.');
    }


    // Show form to edit attendance
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = User::where('role', 'user')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    // Update attendance
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave', // 'Late' removed
            'notes' => 'nullable|string',
        ]);

        // Prevent attendance marking on a leave day
        $isOnLeave = Leave::where('user_id', $request->user_id)
            ->where('status', 'Approved')
            ->where('from_date', '<=', $request->date)
            ->where('to_date', '>=', $request->date)
            ->exists();

        if ($isOnLeave) {
            return redirect()->route('attendance.index')->with('error', 'Cannot update attendance, the employee is on leave.');
        }

        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }


    // Delete attendance
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance deleted.');
    }

    public function report()
    {
        $employees = User::where('role', 'user')
            ->withCount([
                'attendances as present_days' => fn ($query) => $query->where('status', 'Present'),
                'attendances as absent_days' => fn ($query) => $query->where('status', 'Absent'),
                'attendances as leave_days' => fn ($query) => $query->where('status', 'Leave'),
            ])
            ->get();

        $employees->each(function ($employee) {
            // 'late_days' calculation removed
            $employee->performance_score = ($employee->present_days * 2) - ($employee->absent_days * 3);
        });

        $sortedEmployees = $employees->sortByDesc('performance_score');

        return view('attendance.report', ['employees' => $sortedEmployees]);
    }
}