<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

$runningMonth = Carbon::now()->format('Y-m');

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $runningMonth = Carbon::now()->format('Y-m');
        $query = Payment::with('user');

        if($request->month) {
            $query->where('month', $request->month);
        }

        if($request->status) {
            $query->where('status', $request->status);
        }

        $payments = $query->orderBy('month', 'desc')->paginate(15);

       $summary = [
    'total_employees' => User::count(),
    'total_paid' => Payment::where('status', 'paid')->where('month', $runningMonth)->count(),
    'total_pending' => Payment::where('status', 'pending')->count(),
];

        $months = Payment::select('month')->distinct()->orderBy('month','desc')->pluck('month');

        return view('admin.admin_payment', compact('payments', 'summary', 'months'));
    }

    public function download($id)
    {
        $payment = Payment::findOrFail($id);
        $pdf = Pdf::loadView('employee.payments_pdf', compact('payment'));
        return $pdf->download('payslip_'.$payment->month.'.pdf');
    }

    public function markPaid($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'paid';
        $payment->paid_at = now();
        $payment->save();

        return redirect()->back()->with('success', 'Payment marked as paid.');
    }
}
