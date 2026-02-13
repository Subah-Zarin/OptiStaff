<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    // Admin view
    public function index()
    {
        // Added orderBy so admins see holidays in chronological order
        $holidays = Holiday::orderBy('date')->get();
        return view('Leave.admin_holiday', compact('holidays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
        ]);

        Holiday::create($request->all());
        return redirect()->route('holidays.index')->with('success', 'Holiday added successfully!');
    }

    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
        ]);

        $holiday->update($request->all());
        return redirect()->route('holidays.index')->with('success', 'Holiday updated successfully!');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('holidays.index')->with('success', 'Holiday deleted successfully!');
    }

    // Employee view
    public function employeeIndex()
    {
        $holidays = Holiday::orderBy('date')->get();
        return view('Leave.holiday', compact('holidays'));
    }
}