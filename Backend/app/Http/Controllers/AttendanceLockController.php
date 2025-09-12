<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceLock;
use Carbon\Carbon;

class AttendanceLockController extends Controller
{
    public function index()
    {
        $locks = AttendanceLock::orderBy('lock_date', 'desc')->get()->keyBy(function ($item) {
            return $item->lock_date->format('Y-m');
        });

        return view('attendance.lock', compact('locks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $lockDate = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();

        AttendanceLock::updateOrCreate(
            ['lock_date' => $lockDate],
            ['is_locked' => true]
        );

        return back()->with('success', 'Attendance for the selected month has been locked.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $lockDate = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();

        AttendanceLock::where('lock_date', $lockDate)->update(['is_locked' => false]);

        return back()->with('success', 'Attendance for the selected month has been unlocked.');
    }
}