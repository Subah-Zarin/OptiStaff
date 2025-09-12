@extends('layouts.app')

@section('title', 'Lock Attendance')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Lock Attendance Records</h1>
    </div>

    {{-- Session Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <form action="{{ route('attendance.lock.store') }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <label for="month" class="font-semibold">Select Month to Lock:</label>
            <input type="month" id="month" name="month" required class="border rounded px-3 py-2">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                <i class="fas fa-lock mr-2"></i>Lock Period
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <h2 class="text-xl font-bold p-4">Locked Periods</h2>
        <table class="min-w-full border-t border-gray-200 text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border-b">Month</th>
                    <th class="py-3 px-4 border-b">Status</th>
                    <th class="py-3 px-4 border-b text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $current = now();
                    $months = collect([]);
                    for ($i = 0; $i < 12; $i++) {
                        $months->push(clone $current);
                        $current->subMonth();
                    }
                @endphp

                @foreach($months as $month)
                    @php
                        $monthKey = $month->format('Y-m');
                        $lock = $locks->get($monthKey);
                        $isLocked = $lock && $lock->is_locked;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $month->format('F Y') }}</td>
                        <td class="py-2 px-4 border-b">
                            @if($isLocked)
                                <span class="px-2 py-1 rounded text-white bg-red-500">Locked</span>
                            @else
                                <span class="px-2 py-1 rounded text-white bg-green-500">Unlocked</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            @if($isLocked)
                                <form action="{{ route('attendance.lock.destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="month" value="{{ $monthKey }}">
                                    <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Unlock</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection