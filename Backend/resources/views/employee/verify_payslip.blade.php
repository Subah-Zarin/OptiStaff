@extends('layouts.app')

@section('title', 'Verify Payslip')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm p-4 text-center">
        <h3 class="text-primary mb-3">Payslip Verification</h3>

        <p><strong>Employee:</strong> {{ $employee->name }}</p>
        <p><strong>Month:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m', $payment->month)->format('F Y') }}</p>
        <p><strong>Status:</strong>
            <span class="badge {{ $payment->status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ ucfirst($payment->status) }}
            </span>
        </p>

        <p class="text-muted mt-3">
            This payslip is verified and matches our records.
        </p>
    </div>
</div>
@endsection
