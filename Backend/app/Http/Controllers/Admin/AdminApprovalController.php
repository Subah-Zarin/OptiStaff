<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminApprovalController extends Controller
{
    // List all pending admin requests
    public function index()
    {
        $pendingAdmins = User::where('role', 'admin')
                             ->where('status', 'pending')
                             ->get();

        return view('admin.approvals.index', compact('pendingAdmins'));
    }

    // Approve an admin
    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        // Mark related notifications as read
        auth()->user()->notifications()
            ->where('data->applicant_id', $user->id)
            ->update(['read_at' => now()]);

        return back()->with('success', "{$user->name} has been approved as admin.");
    }

    // Reject an admin
    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        auth()->user()->notifications()
            ->where('data->applicant_id', $user->id)
            ->update(['read_at' => now()]);

        return back()->with('success', "{$user->name}'s admin request has been rejected.");
    }
}