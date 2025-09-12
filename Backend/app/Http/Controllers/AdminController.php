<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $presentCount = Attendance::whereDate('date', $today)
            ->where('status', 'Present')
            ->count();

        $absentCount = Attendance::whereDate('date', $today)
            ->where('status', 'Absent')
            ->count();

        $leaveCount = Attendance::whereDate('date', $today)
            ->where('status', 'Leave')
            ->count();

        return view('admin.dashboard', [
            'presentCount' => $presentCount,
            'absentCount' => $absentCount,
            'leaveCount' => $leaveCount,
        ]);
    }
}