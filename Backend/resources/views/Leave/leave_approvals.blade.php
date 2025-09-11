@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Assuming sidebar takes col-2 -->
        <div class="col-lg-10 offset-lg-0 py-4">
            <h2 class="fw-bold mb-4">Employee Leave Requests</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-3">
                @forelse($leaves as $leave)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $leave->user->name }}</h5>
                                <p class="mb-1"><strong>Type:</strong> {{ ucfirst($leave->leave_type) }}</p>
                                <p class="mb-1"><strong>Duration:</strong> {{ ucfirst($leave->duration) }}</p>
                                <p class="mb-1"><strong>From:</strong> {{ \Carbon\Carbon::parse($leave->from_date)->format('d M, Y') }}</p>
                                <p class="mb-1"><strong>To:</strong> {{ \Carbon\Carbon::parse($leave->to_date)->format('d M, Y') }}</p>
                                <p class="mb-2"><strong>Days:</strong> {{ $leave->number_of_days }}</p>

                                <div class="mb-3">
                                    <span class="badge 
                                        @if(strtolower($leave->status) == 'pending') bg-warning text-dark
                                        @elseif(strtolower($leave->status) == 'approved') bg-success
                                        @else bg-danger
                                        @endif p-2">
                                        @if(strtolower($leave->status) == 'pending')
                                            <i class="bi bi-hourglass-split me-1"></i>
                                        @elseif(strtolower($leave->status) == 'approved')
                                            <i class="bi bi-check-circle me-1"></i>
                                        @else
                                            <i class="bi bi-x-circle me-1"></i>
                                        @endif
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </div>

                                @if(strtolower($leave->status) == 'pending')
                                    <div class="mt-auto d-flex gap-2">
                                        <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="flex-fill">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success w-100 shadow-sm">
                                                <i class="bi bi-check-circle me-1"></i> Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('leave.reject', $leave->id) }}" method="POST" class="flex-fill">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger w-100 shadow-sm">
                                                <i class="bi bi-x-circle me-1"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">No action needed</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            No leave requests found.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    .card:hover {
        transform: translateY(-3px);
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .badge {
        font-size: 0.9rem;
    }

    .btn {
        font-weight: 500;
    }

    @media (max-width: 991px) {
        .col-lg-10.offset-lg-2 {
            offset: 0;
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endsection
