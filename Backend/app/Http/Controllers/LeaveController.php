<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LeaveController extends Controller
{
    // Show "My Leave" page
    public function index() {
        $userId = Auth::id();

        // Fetch all leaves of the user
        $leaves = Leave::where('user_id', $userId)->latest()->get();

        // Define total leave entitlement (adjust as needed)
        $totalLeaves = [
            'Casual' => 12,
            'Sick'   => 10,
            'Earned' => 15,
        ];

        // Calculate used leaves (Approved only)
        $usedLeaves = [
            'Casual' => $leaves->where('leave_type', 'Casual')->where('status', 'Approved')->sum('number_of_days'),
            'Sick'   => $leaves->where('leave_type', 'Sick')->where('status', 'Approved')->sum('number_of_days'),
            'Earned' => $leaves->where('leave_type', 'Earned')->where('status', 'Approved')->sum('number_of_days'),
        ];

        // Remaining leaves
        $remainingLeaves = [
            'Casual' => $totalLeaves['Casual'] - $usedLeaves['Casual'],
            'Sick'   => $totalLeaves['Sick'] - $usedLeaves['Sick'],
            'Earned' => $totalLeaves['Earned'] - $usedLeaves['Earned'],
        ];

        return view('Leave.myleave', compact('leaves', 'remainingLeaves'));
    }

    // Show leave request form
    public function create() {
        return view('Leave.request');
    }

    // Store leave request
    public function store(Request $request) {
        $request->validate([
            'leave_type'    => 'required|string',
            'duration'      => 'required|in:Full,Half',
            'from_date'     => 'required|date',
            'to_date'       => 'nullable|date|after_or_equal:from_date',
            'half_day_type' => 'nullable|in:AM,PM',
        ]);

        // Calculate number of days
        if($request->duration === 'Half') {
            $days = 0.5;
            // For half day, to_date is optional
            $toDate = $request->from_date;
        } else {
            $from = new \DateTime($request->from_date);
            $to   = new \DateTime($request->to_date ?? $request->from_date);
            $days = $from->diff($to)->days + 1;
            $toDate = $request->to_date ?? $request->from_date;
        }

        Leave::create([
            'user_id'       => Auth::id(),
            'leave_type'    => $request->leave_type,
            'duration'      => $request->duration,
            'half_day_type' => $request->duration === 'Half' ? $request->half_day_type : null,
            'from_date'     => $request->from_date,
            'to_date'       => $toDate,
            'number_of_days'=> $days,
            'status'        => 'Pending',
        ]);

        return redirect()->route('leave.index')->with('success', 'Leave request submitted successfully.');
    }

    // Cancel pending leave request
    public function destroy($id) {
        $leave = Leave::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        if($leave->status == 'Pending') {
            $leave->delete();
            return back()->with('success', 'Leave request canceled.');
        }
        return back()->with('error', 'Cannot cancel approved/rejected leave.');
    }

    public function approvals() {
    // Fetch all leave requests with user info
    $leaves = Leave::with('user')->latest()->get();
    return view('Leave.leave_approvals', compact('leaves'));
}

public function approve($id) {
    $leave = Leave::findOrFail($id);
    $leave->update(['status' => 'Approved']); // Capitalize for consistency

    // Auto-mark attendance as 'Leave'
    $period = CarbonPeriod::create($leave->from_date, $leave->to_date);
    foreach ($period as $date) {
        Attendance::updateOrCreate(
            ['user_id' => $leave->user_id, 'date' => $date->toDateString()],
            ['status' => 'Leave']
        );
    }

    return back()->with('success', 'Leave approved successfully!');
}

public function reject($id) {
    $leave = Leave::findOrFail($id);
    $leave->update(['status' => 'Rejected']); // Capitalize for consistency
    return back()->with('success', 'Leave rejected successfully!');
}

// Admin: leave status report (who’s on leave, returned, balances)
    public function status()
    {
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $today = now()->toDateString();
        $approvedStatuses = ['Approved', 'approved'];

        // Who is on leave today
        $onLeaveToday = Leave::with('user')
            ->whereIn('status', $approvedStatuses)
            ->whereDate('from_date', '<=', $today)
            ->whereDate('to_date', '>=', $today)
            ->orderBy('from_date', 'desc')
            ->get();

        // Who recently returned (last 30 days)
        $recentlyReturned = Leave::with('user')
            ->whereIn('status', $approvedStatuses)
            ->whereDate('to_date', '<', $today)
            ->whereDate('to_date', '>=', now()->subDays(30)->toDateString())
            ->orderBy('to_date', 'desc')
            ->get();

        // Totals per employee
        $totalsUsed = Leave::select('user_id', DB::raw('SUM(number_of_days) as total_used'))
            ->whereIn('status', $approvedStatuses)
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $users = User::select('id','name','email')->orderBy('name')->get();

        // Organization entitlement (adjust if needed)
        $totalEntitlement = 12 + 10 + 15; // 37 days

        $summary = $users->map(function ($user) use ($totalsUsed, $totalEntitlement) {
            $used = isset($totalsUsed[$user->id]) ? (float) $totalsUsed[$user->id]->total_used : 0.0;
            $remaining = max($totalEntitlement - $used, 0);
            return (object) [
                'user'         => $user,
                'used'         => $used,
                'remaining'    => $remaining,
                'entitlement'  => $totalEntitlement,
                'used_percent' => $totalEntitlement > 0 ? round(($used / $totalEntitlement) * 100) : 0,
            ];
        });

        $metrics = [
            'totalEmployees'   => $users->count(),
            'onLeaveToday'     => $onLeaveToday->count(),
            'recentlyReturned' => $recentlyReturned->count(),
            'totalDaysUsedOrg' => (float) $totalsUsed->sum('total_used'),
            'totalEntitlement' => $totalEntitlement,
        ];

        return view('Leave.leave_status', compact('onLeaveToday', 'recentlyReturned', 'summary', 'metrics'));
    }


}