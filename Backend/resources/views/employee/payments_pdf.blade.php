<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Pay Slip - {{ \Carbon\Carbon::createFromFormat('Y-m', $payment->month)->format('F Y') }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; margin: 30px; font-size: 14px; }
        .header, .footer { text-align: center; }
        .company-logo { width: 120px; height: auto; margin-bottom: 10px; }
        .company-name { font-size: 20px; font-weight: bold; margin: 0; }
        .company-details { font-size: 12px; color: #555; margin-bottom: 20px; }
        h2 { color: #0d6efd; margin-bottom: 10px; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-top: 5px; }
        .paid { background-color: #28a745; color: white; }
        .pending { background-color: #ffc107; color: #333; }
        .section { margin-bottom: 25px; }
        .section-title { font-weight: bold; margin-bottom: 10px; color: #0d6efd; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #0d6efd; color: white; }
        .text-right { text-align: right; }
        .total { background-color: #28a745; color: white; font-weight: bold; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; }
        .qr { width: 80px; margin-top: 10px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .info-label { font-weight: bold; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header section">
        <img src="{{ public_path('images/company_logo.png') }}" alt="Company Logo" class="company-logo">
        <div class="company-name">OptiStaff Pvt Ltd.</div>
        <div class="company-details">
            123 Corporate Avenue, Dhaka, Bangladesh<br>
            Phone: +880 1234 567890 | Website: www.optistaff.com
        </div>
        <span class="badge {{ $payment->status == 'paid' ? 'paid' : 'pending' }}">
            {{ ucfirst($payment->status) }}
        </span>
    </div>

    {{-- Employee Info --}}
    <div class="section">
        <div class="section-title">Employee Details</div>
        <div class="info-row"><span class="info-label">Employee Name:</span> {{ auth()->user()->name }}</div>
        <div class="info-row"><span class="info-label">Designation:</span> {{ $payment->designation ?? 'Staff' }}</div>
        <div class="info-row"><span class="info-label">Month:</span> {{ \Carbon\Carbon::createFromFormat('Y-m', $payment->month)->format('F Y') }}</div>
        <div class="info-row"><span class="info-label">Work Days:</span> {{ $payment->work_days ?? '22' }}</div>
        <div class="info-row"><span class="info-label">Gross Salary:</span> {{ number_format($payment->gross_salary ?? 40000) }} TK</div>
        <div class="info-row"><span class="info-label">Net Salary:</span> {{ number_format($payment->final_salary) }} TK</div>
        <div class="info-row"><span class="info-label">Absence:</span> {{ $payment->absent_days }} Days</div>
        <div class="info-row"><span class="info-label">Scale of Payment:</span> {{ $payment->scale_of_payment ?? 'Monthly' }}</div>
    </div>

    {{-- Salary Breakdown --}}
    <div class="section">
        <div class="section-title">Salary Details</div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Amount (TK)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Standard Working Days in a Month</td>
                    <td class="text-right">{{ $payment->standard_days ?? 22 }}</td>
                </tr>
                <tr>
                    <td>Standard Working Hours (Daily)</td>
                    <td class="text-right">{{ $payment->standard_hours ?? 8 }}</td>
                </tr>
                <tr>
                    <td>Training Rate</td>
                    <td class="text-right">{{ number_format($payment->training_rate ?? 0) }}</td>
                </tr>
                <tr>
                    <td>Medical Allowance</td>
                    <td class="text-right">{{ number_format($payment->medical_allowance ?? 0) }}</td>
                </tr>
                <tr>
                    <td>Transportation Allowance</td>
                    <td class="text-right">{{ number_format($payment->transportation_allowance ?? 0) }}</td>
                </tr>
                <tr>
                    <td>Earnings</td>
                    <td class="text-right">{{ number_format($payment->earnings ?? 40000) }}</td>
                </tr>
                <tr>
                    <td>Deductions</td>
                    <td class="text-right text-danger">- {{ number_format($payment->deduction) }}</td>
                </tr>
                <tr class="total">
                    <td>Total Net Payment</td>
                    <td class="text-right">{{ number_format($payment->final_salary) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Bank Details --}}
    <div class="section">
        <div class="section-title">Bank Details</div>
        <div class="info-row"><span class="info-label">Bank Name:</span> {{ $payment->bank_name ?? 'Bank of Dhaka' }}</div>
        <div class="info-row"><span class="info-label">Holder Name:</span> {{ auth()->user()->name }}</div>
        <div class="info-row"><span class="info-label">Account Number:</span> {{ $payment->account_number ?? '0123456789' }}</div>
        <div class="info-row"><span class="info-label">Branch:</span> {{ $payment->branch ?? 'Dhaka Main' }}</div>
        <div class="info-row"><span class="info-label">Payment Date:</span> {{ $payment->paid_at ? $payment->paid_at->format('d M Y') : '-' }}</div>
    </div>

    {{-- QR Code --}}
    <div class="section text-center">
        @php
            use SimpleSoftwareIO\QrCode\Facades\QrCode;
        @endphp
        {!! QrCode::size(80)->generate(route('employee.payments.verify', $payment->id)) !!}
        <div><small>Scan QR code to verify pay slip</small></div>
    </div>

    <div class="footer">
        This is a computer-generated payslip. No signature is required.
    </div>
</body>
</html>
