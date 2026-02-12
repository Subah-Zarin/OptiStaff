@extends('layouts.app')

@section('title', 'My Salary')

@section('content')
<div class="container py-5" x-data="salaryPage()" style="font-family: 'Inter', sans-serif;">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h3 class="fw-bold text-primary" style="font-family: 'Inter', sans-serif;">Salary & Payment History</h3>
        <select x-model="selectedMonth" class="form-select w-auto shadow-sm border-0 rounded-pill px-3 py-2">
            <option value="">All Months</option>
            @foreach($payments as $payment)
                <option value="{{ $payment->month }}">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $payment->month)->format('F Y') }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Current Month Payslip --}}
    @php $currentPayment = $payments->firstWhere('month', $currentMonth); @endphp
    @if($currentPayment)
    <div class="card shadow-sm border-0 rounded-4 mb-4" 
         x-show="selectedMonth === '' || selectedMonth === '{{ $currentPayment->month }}'">
        <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3 rounded-top cursor-pointer"
             @click="toggle({{ $currentPayment->id }})">
            <span class="fw-semibold text-dark fs-5">
                {{ \Carbon\Carbon::createFromFormat('Y-m', $currentPayment->month)->format('F Y') }} (Current)
            </span>
            @if($currentPayment->status == 'paid')
                <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">Paid</span>
            @else
                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm">Pending</span>
            @endif
        </div>

        <div x-show="openId === {{ $currentPayment->id }}" x-transition class="card-body bg-light px-4 py-4 rounded-bottom">
            {{-- Payslip Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold text-primary">Pay Slip</h5>
                    <small class="text-muted">Employee: {{ auth()->user()->name }}</small>
                </div>
                <div class="text-end">
                    <strong>Month:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m', $currentPayment->month)->format('F Y') }}
                </div>
            </div>

            {{-- Salary Table --}}
            <table class="table table-striped table-hover shadow-sm mb-3 rounded">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>Description</th>
                        <th class="text-end">Amount (TK)</th>
                        <th class="text-end">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-end">{{ number_format($currentPayment->basic_salary) }}</td>
                        <td class="text-end">Standard</td>
                    </tr>
                    <tr>
                        <td>Absent Days</td>
                        <td class="text-end">{{ $currentPayment->absent_days }} Days</td>
                        <td class="text-end">Deduction Applied</td>
                    </tr>
                    <tr>
                        <td>Deduction (100 TK per day)</td>
                        <td class="text-end text-danger">- {{ number_format($currentPayment->deduction) }}</td>
                        <td class="text-end">Late/Absent</td>
                    </tr>
                    <tr>
                        <td>Medical Allowance</td>
                        <td class="text-end">{{ number_format($currentPayment->medical_allowance ?? 0) }}</td>
                        <td class="text-end">As per policy</td>
                    </tr>
                    <tr>
                        <td>Transportation Allowance</td>
                        <td class="text-end">{{ number_format($currentPayment->transportation_allowance ?? 0) }}</td>
                        <td class="text-end">Monthly</td>
                    </tr>
                    <tr class="fw-bold text-success fs-6">
                        <td>Final Salary</td>
                        <td class="text-end">{{ number_format($currentPayment->final_salary) }}</td>
                        <td class="text-end">Net Pay</td>
                    </tr>
                </tbody>
            </table>

            {{-- Payment Info & Download --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    @if($currentPayment->paid_at)
                        <small class="text-muted">Paid on {{ $currentPayment->paid_at->format('d M Y') }}</small>
                    @endif
                </div>
                <a href="{{ route('employee.payments.download', $currentPayment->id) }}"
                   class="btn btn-success btn-sm px-4 py-2 shadow-sm">Download PDF</a>
            </div>
        </div>
    </div>
    @endif

    {{-- Previous Paid Payslips --}}
    @php $previousPayments = $payments->where('status', 'paid')->where('month', '<', $currentMonth)->sortByDesc('month'); @endphp
    @foreach($previousPayments as $prev)
    <div class="card shadow-sm border-0 rounded-4 mb-3"
         x-show="selectedMonth === '' || selectedMonth === '{{ $prev->month }}'">
        <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3 rounded-top cursor-pointer"
             @click="toggle({{ $prev->id }})">
            <span class="fw-semibold text-dark fs-6">
                {{ \Carbon\Carbon::createFromFormat('Y-m', $prev->month)->format('F Y') }}
            </span>
            <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">Paid</span>
        </div>
        <div x-show="openId === {{ $prev->id }}" x-transition class="card-body bg-light px-4 py-3 rounded-bottom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <strong>Pay Slip</strong>
                    <small class="text-muted">Employee: {{ auth()->user()->name }}</small>
                </div>
                <div class="text-end">
                    <strong>Month:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m', $prev->month)->format('F Y') }}
                </div>
            </div>
            <table class="table table-striped table-hover shadow-sm mb-3 rounded">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Description</th>
                        <th class="text-end">Amount (TK)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-end">{{ number_format($prev->basic_salary) }}</td>
                    </tr>
                    <tr>
                        <td>Deduction</td>
                        <td class="text-end text-danger">- {{ number_format($prev->deduction) }}</td>
                    </tr>
                    <tr class="fw-bold text-success">
                        <td>Final Salary</td>
                        <td class="text-end">{{ number_format($prev->final_salary) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="text-end">
                <a href="{{ route('employee.payments.download', $prev->id) }}"
                   class="btn btn-outline-success btn-sm px-4 py-1 shadow-sm">Download PDF</a>
            </div>
        </div>
    </div>
    @endforeach

</div>

<script>
function salaryPage() {
    return {
        openId: {{ $payments->firstWhere('month', $currentMonth)?->id ?? 'null' }},
        selectedMonth: '',
        toggle(id) {
            this.openId = this.openId === id ? null : id;
        }
    }
}
</script>

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection
