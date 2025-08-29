<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    return back()->with('success', 'Leave approved successfully!');
}

public function reject($id) {
    $leave = Leave::findOrFail($id);
    $leave->update(['status' => 'Rejected']); // Capitalize for consistency
    return back()->with('success', 'Leave rejected successfully!');
}

}
