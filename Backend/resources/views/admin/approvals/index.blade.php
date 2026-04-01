@extends('layouts.app')

@section('content')
<div class="p-6">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Pending Admin Approvals</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($pendingAdmins->isEmpty())
        <div class="bg-white p-6 rounded-xl shadow text-gray-500">
            No pending admin requests.
        </div>
    @else
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Registered At</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingAdmins as $admin)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $admin->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $admin->email }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $admin->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <form method="POST" action="{{ route('admin.approvals.approve', $admin) }}">
                                @csrf
                                <button class="px-4 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs rounded-lg transition">
                                    ✓ Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.approvals.reject', $admin) }}">
                                @csrf
                                <button class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs rounded-lg transition">
                                    ✗ Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection