@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-6">Employee Details</h2>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex flex-col items-center space-y-6 mb-6">
            <!-- Profile Photo -->
           <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                         class="w-25 h-25 md:w-40 md:h-40 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ffffff&color=6c757d&size=200"
                         class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white shadow-lg">
                @endif
            </div>

            <!-- Employee Info -->
            <div class="text-center space-y-2">
                <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                <p class="text-gray-600"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="text-gray-600"><strong>Role:</strong> {{ ucfirst($user->role ?? 'N/A') }}</p>
                <p class="text-gray-600"><strong>Birthdate:</strong> {{ $user->birthdate ?? 'N/A' }}</p>
                <p class="text-gray-600"><strong>Gender:</strong> {{ ucfirst($user->gender ?? 'N/A') }}</p>
                <p class="text-gray-600"><strong>Joined At:</strong> {{ $user->created_at->format('d M, Y') }}</p>
                <p class="text-gray-600"><strong>Last Updated:</strong> {{ $user->updated_at->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-center gap-4">
            <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow">
                Back to Directory
            </a>
              <!-- Download PDF Button (only for admin) -->
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('employees.download', $user->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow">
                    Download PDF
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
