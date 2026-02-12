<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payment;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Total employees
        $totalEmployees = User::count();

        // Attendance today
        $presentCount = Schema::hasColumn('attendances', 'status') 
            ? Attendance::where('date', $today)->where('status', 'Present')->count() 
            : 0;
        $absentCount = Schema::hasColumn('attendances', 'status') 
            ? Attendance::where('date', $today)->where('status', 'Absent')->count() 
            : 0;
        $leaveCountToday = Schema::hasColumn('attendances', 'status') 
            ? Attendance::where('date', $today)->where('status', 'On Leave')->count() 
            : 0;

        // KPI Summary
        $totalLeavesThisMonth = Schema::hasColumn('leaves', 'from_date') 
            ? Leave::whereMonth('from_date', Carbon::now()->month)->count() 
            : 0;

        $pendingApprovals = Schema::hasColumn('leaves', 'status') 
            ? Leave::where('status', 'Pending')->count() 
            : 0;

        $payrollReady = Schema::hasTable('payments') 
            ? Payment::count() // fallback: count of payments
            : 0;

        $holidaysLeft = Schema::hasTable('holidays') 
            ? Holiday::where('date', '>=', $today)->count() 
            : 0;

        $upcomingHolidays = Schema::hasTable('holidays') 
            ? Holiday::where('date', '>=', $today)->orderBy('date', 'asc')->take(5)->get() 
            : collect();

        // --- Chart Data ---

        // Attendance Trends (Last 7 days)
        $attendanceLabels = [];
        $attendancePresent = [];
        $attendanceAbsent = [];
        $attendanceLeave = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $attendanceLabels[] = Carbon::parse($date)->format('d M');

            $attendancePresent[] = Schema::hasColumn('attendances', 'status') 
                ? Attendance::where('date', $date)->where('status', 'Present')->count() 
                : 0;

            $attendanceAbsent[] = Schema::hasColumn('attendances', 'status') 
                ? Attendance::where('date', $date)->where('status', 'Absent')->count() 
                : 0;

            $attendanceLeave[] = Schema::hasColumn('attendances', 'status') 
                ? Attendance::where('date', $date)->where('status', 'On Leave')->count() 
                : 0;
        }

        // Leave Trends (Last 6 months)
        $leaveLabels = [];
        $leaveCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $leaveLabels[] = $month->format('M Y');
            $leaveCounts[] = Schema::hasColumn('leaves', 'from_date') 
                ? Leave::whereMonth('from_date', $month->month)
                    ->whereYear('from_date', $month->year)
                    ->count() 
                : 0;
        }

        // Payroll Overview (Last 6 months) — fallback to count if amount column missing
        $payrollLabels = [];
        $payrollCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $payrollLabels[] = $month->format('M Y');

            if (Schema::hasColumn('payments', 'amount') && Schema::hasColumn('payments', 'payment_date')) {
                $payrollCounts[] = Payment::whereMonth('payment_date', $month->month)
                    ->whereYear('payment_date', $month->year)
                    ->sum('amount');
            } elseif (Schema::hasColumn('payments', 'payment_date')) {
                $payrollCounts[] = Payment::whereMonth('payment_date', $month->month)
                    ->whereYear('payment_date', $month->year)
                    ->count();
            } else {
                $payrollCounts[] = 0;
            }
        }

        return view('admin.dashboard', compact(
            'totalEmployees', 'presentCount', 'absentCount', 'leaveCountToday',
            'totalLeavesThisMonth', 'pendingApprovals', 'payrollReady', 'holidaysLeft',
            'upcomingHolidays',
            'attendanceLabels', 'attendancePresent', 'attendanceAbsent', 'attendanceLeave',
            'leaveLabels', 'leaveCounts',
            'payrollLabels', 'payrollCounts'
        ));
    }
}
