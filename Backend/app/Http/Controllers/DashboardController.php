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
        $presentDays = Attendance::where('user_id', $user->id)
                        ->where('status', 'Present')
                        ->count();

        // FIXED LATE LOGIC: Status is Present, but check_in is after 09:30:00
        $lateDays = Attendance::where('user_id', $user->id)
                        ->where('status', 'Present')
                        ->whereTime('check_in', '>', '09:30:00')
                        ->count();

        $absentDays = Attendance::where('user_id', $user->id)
                        ->where('status', 'Absent')
                        ->count();

        // FIXED LEAVE SUMMARY LOGIC: Using standard company entitlements and summing actual days
        $totalLeaves = ['Casual' => 12, 'Sick' => 10, 'Earned' => 15];
        $leaveSummary = [];
        
        foreach (['Casual', 'Sick', 'Earned'] as $type) {
            $taken = Leave::where('user_id', $user->id)
                          ->where('leave_type', $type)
                          ->where('status', 'Approved')
                          ->sum('number_of_days');
                          
            $leaveSummary[$type] = [
                'total' => $totalLeaves[$type],
                'taken' => $taken,
                'remaining' => $totalLeaves[$type] - $taken
            ];
        }

        // Pending & Approved leave requests count (for the top cards)
        $pendingLeaves = Leave::where('user_id', $user->id)
                        ->where('status', 'Pending')
                        ->count();

        $approvedLeaves = Leave::where('user_id', $user->id)
                        ->where('status', 'Approved')
                        ->count();

        // Attendance chart data (Mon-Fri)
        $attendanceData = [
            'Mon' => Attendance::where('user_id', $user->id)->whereDate('date', now()->startOfWeek())->where('status', 'Present')->count(),
            'Tue' => Attendance::where('user_id', $user->id)->whereDate('date', now()->startOfWeek()->addDay(1))->where('status', 'Present')->count(),
            'Wed' => Attendance::where('user_id', $user->id)->whereDate('date', now()->startOfWeek()->addDay(2))->where('status', 'Present')->count(),
            'Thu' => Attendance::where('user_id', $user->id)->whereDate('date', now()->startOfWeek()->addDay(3))->where('status', 'Present')->count(),
            'Fri' => Attendance::where('user_id', $user->id)->whereDate('date', now()->startOfWeek()->addDay(4))->where('status', 'Present')->count(),
        ];

        // Leave type counts for Doughnut Chart
        $casualLeave = $leaveSummary['Casual']['taken'];
        $sickLeave = $leaveSummary['Sick']['taken'];
        $otherLeave = $leaveSummary['Earned']['taken'];

        // Example: Employee type distribution (replace with real data when you have it)
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