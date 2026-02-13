@extends('layouts.app')
@section('title', 'Leave Request')
@section('content')
<div class="container mx-auto p-6 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Request Leave</h1>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('leave.store') }}" method="POST" class="bg-white p-6 rounded shadow" id="leaveForm">
        @csrf

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

            <div id="halfDaySelect" class="mt-2 hidden">
                <label class="block font-medium mb-1">Select Half Day</label>
                <select name="half_day_type" class="w-full border rounded p-2">
                    <option value="AM">Morning (AM)</option>
                    <option value="PM">Afternoon (PM)</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label for="from_date" class="block font-medium mb-1">From Date</label>
            <input type="date" name="from_date" id="from_date" min="{{ date('Y-m-d') }}" class="w-full border rounded p-2">
            @error('from_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="to_date" class="block font-medium mb-1">To Date</label>
            <input type="date" name="to_date" id="to_date" min="{{ date('Y-m-d') }}" class="w-full border rounded p-2">
            <p class="text-gray-400 text-sm mt-1">Optional if applying for a single day</p>
            @error('to_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Request</button>
    </form>
</div>

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

    // Optional: Auto-calculate total days on submit (skipping Friday and Saturday)
    const form = document.getElementById('leaveForm');
    form.addEventListener('submit', function(e) {
        const fromDateInput = document.getElementById('from_date').value;
        const toDateInput = document.getElementById('to_date').value;
        const duration = document.querySelector('input[name="duration"]:checked').value;

        if (!fromDateInput) return; // Prevent calculation if no date

        const fromDate = new Date(fromDateInput);
        let days = 0;

        if (toDateInput) {
            const toDate = new Date(toDateInput);
            let currentDate = new Date(fromDate);
            
            // Loop through dates and skip Friday (5) and Saturday (6)
            while (currentDate <= toDate) {
                let dayOfWeek = currentDate.getDay();
                if (dayOfWeek !== 5 && dayOfWeek !== 6) {
                    days++;
                }
                currentDate.setDate(currentDate.getDate() + 1);
            }
        } else {
            let dayOfWeek = fromDate.getDay();
            days = (dayOfWeek !== 5 && dayOfWeek !== 6) ? 1 : 0;
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