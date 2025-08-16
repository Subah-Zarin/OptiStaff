<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Attendance data
        $presentDays = Attendance::where('employee_id', $user->id)
                            ->where('status', 'Present')
                            ->count();

        $lateDays = Attendance::where('employee_id', $user->id)
                        ->where('status', 'Late')
                        ->count();

        $absentDays = Attendance::where('employee_id', $user->id)
                            ->where('status', 'Absent')
                            ->count();

        // Leave summary
        $leaveSummary = Leave::where('user_id', $user->id)
                        ->get()
                        ->groupBy('leave_type')
                        ->map(function ($leaves) {
                            $total = $leaves->count();
                            $taken = $leaves->where('status', 'Approved')->count();
                            return [
                                'total' => $total,
                                'taken' => $taken,
                                'remaining' => $total - $taken
                            ];
                        });

        // Pending & Approved leaves
        $pendingLeaves = Leave::where('user_id', $user->id)
                        ->where('status', 'Pending')
                        ->count();

        $approvedLeaves = Leave::where('user_id', $user->id)
                        ->where('status', 'Approved')
                        ->count();

        // Example: Attendance for chart (Mon-Fri)
        $attendanceData = [
            'Mon' => 1,
            'Tue' => 1,
            'Wed' => 0,
            'Thu' => 1,
            'Fri' => 1,
        ];

        // Example: Leave chart data
        $casualLeave = Leave::where('user_id', $user->id)
                        ->where('leave_type', 'Casual')->count();
        $sickLeave = Leave::where('user_id', $user->id)
                        ->where('leave_type', 'Sick')->count();
        $otherLeave = Leave::where('user_id', $user->id)
                        ->where('leave_type', 'Other')->count();

        // Example: Employee type distribution (replace with real data)
        $fullTime = 400;
        $partTime = 100;
        $internship = 50;

        return view('dashboard.dashboard', compact(
            'user', 'presentDays', 'lateDays', 'absentDays',
            'leaveSummary', 'pendingLeaves', 'approvedLeaves',
            'attendanceData', 'casualLeave', 'sickLeave', 'otherLeave',
            'fullTime', 'partTime', 'internship'
        ));
    }
}
