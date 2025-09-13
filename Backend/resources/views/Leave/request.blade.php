@extends('layouts.app')
@section('title', 'Leave Request')
@section('content')
<div class="container mx-auto p-6 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Request Leave</h1>

    <form action="{{ route('leave.store') }}" method="POST" class="bg-white p-6 rounded shadow" id="leaveForm">
        @csrf

        <!-- Leave Type -->
        <div class="mb-4">
            <label for="leave_type" class="block font-medium mb-1">Leave Type</label>
            <select name="leave_type" id="leave_type" class="w-full border rounded p-2">
                <option value="Casual">Casual</option>
                <option value="Sick">Sick</option>
                <option value="Earned">Earned</option>
            </select>
            @error('leave_type')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Duration -->
        <div class="mb-4">
            <label class="block font-medium mb-1">Duration</label>
            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="duration" value="Full" checked class="form-radio">
                    <span class="ml-2">Full Day</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="duration" value="Half" class="form-radio">
                    <span class="ml-2">Half Day</span>
                </label>
            </div>

            <!-- AM/PM selection for Half Day -->
            <div id="halfDaySelect" class="mt-2 hidden">
                <label class="block font-medium mb-1">Select Half Day</label>
                <select name="half_day_type" class="w-full border rounded p-2">
                    <option value="AM">Morning (AM)</option>
                    <option value="PM">Afternoon (PM)</option>
                </select>
            </div>
        </div>

        <!-- From Date -->
        <div class="mb-4">
            <label for="from_date" class="block font-medium mb-1">From Date</label>
            <input type="date" name="from_date" id="from_date" class="w-full border rounded p-2">
            @error('from_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- To Date -->
        <div class="mb-4">
            <label for="to_date" class="block font-medium mb-1">To Date</label>
            <input type="date" name="to_date" id="to_date" class="w-full border rounded p-2">
            <p class="text-gray-400 text-sm mt-1">Optional if applying for a single day</p>
            @error('to_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Request</button>
    </form>
</div>

<!-- JS for Half Day toggle -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const durationRadios = document.querySelectorAll('input[name="duration"]');
    const halfDaySelect = document.getElementById('halfDaySelect');

    durationRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Half') {
                halfDaySelect.classList.remove('hidden');
            } else {
                halfDaySelect.classList.add('hidden');
            }
        });
    });

    // Optional: Auto-calculate total days on submit
    const form = document.getElementById('leaveForm');
    form.addEventListener('submit', function(e) {
        const fromDate = new Date(document.getElementById('from_date').value);
        const toDateInput = document.getElementById('to_date').value;
        const duration = document.querySelector('input[name="duration"]:checked').value;

        let days = 0;
        if (toDateInput) {
            const toDate = new Date(toDateInput);
            days = Math.ceil((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;
        } else {
            days = 1;
        }

        if (duration === 'Half') {
            days = 0.5;
        }

        // Create hidden input to send calculated days
        let daysInput = document.createElement('input');
        daysInput.type = 'hidden';
        daysInput.name = 'number_of_days';
        daysInput.value = days;
        form.appendChild(daysInput);
    });
});
</script>
@endsection
