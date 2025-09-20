@extends('layouts.app')
@section('title', 'Holiday')
@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Public Holidays in Bangladesh - 2025</h1>

    <div class="bg-white rounded-xl shadow p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Holiday</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($holidays as $holiday)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-700">{{ $holiday->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($holiday->date)->format('d M, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-500 text-center">No holidays found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
