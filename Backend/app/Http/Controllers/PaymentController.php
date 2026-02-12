<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PaymentController extends Controller
{
    const BASIC_SALARY = 40000;
    const ABSENT_DEDUCTION = 100;

    /*
    |--------------------------------------------------------------------------
    | Employee Salary Page
    |--------------------------------------------------------------------------
    */
public function employeeIndex()
{
    $user = Auth::user();
    $now = Carbon::now();
    $currentMonth = $now->format('Y-m');

    // Check if salary already exists
    $payment = Payment::where('user_id', $user->id)
        ->where('month', $currentMonth)
        ->first();

    if (!$payment) {
        $absentDays = Attendance::where('user_id', $user->id)
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->where('status', 'Absent')
            ->count();

        $deduction = $absentDays * self::ABSENT_DEDUCTION;
        $finalSalary = self::BASIC_SALARY - $deduction;

        $payment = Payment::create([
            'user_id'      => $user->id,
            'month'        => $currentMonth,
            'basic_salary' => self::BASIC_SALARY,
            'absent_days'  => $absentDays,
            'deduction'    => $deduction,
            'final_salary' => $finalSalary,
            'status'       => 'pending',
            'paid_at'      => null,
        ]);
    }

    // Fetch all payments for this employee
    $query = Payment::where('user_id', $user->id);
    if (request('month')) {
        $query->where('month', request('month'));
    }
    $payments = $query->orderBy('month', 'desc')->get();

    // Get the previous paid payment (skip latest)
    $previousPaid = Payment::where('user_id', $user->id)
                        ->where('status', 'paid')
                        ->where('month', '<', $currentMonth) // Only before current month
                        ->orderBy('month', 'desc')
                        ->first();


    // Pass $previousPaid to the view
    return view('employee.payments', compact('payments', 'currentMonth', 'previousPaid'));
}


    /*
    |--------------------------------------------------------------------------
    | Download Payslip PDF
    |--------------------------------------------------------------------------
    */

public function employeeDownload($id)
{
    $payment = Payment::findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('employee.payments_pdf', compact('payment'));
    return $pdf->download('payslip_'.$payment->month.'.pdf');
}
public function verify($id)
{
    $payment = Payment::findOrFail($id);
    $employee = $payment->user; // Assuming your Payment model has a user() relation

    return view('employee.verify_payslip', compact('payment', 'employee'));
}


}
