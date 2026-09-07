<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\PaymentType;
use App\Models\PaymentLoad;
use App\Models\Student;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function dashboard()
    {
        $totalEarnings = StudentPayment::sum('amount_paid');
        $recentPayments = StudentPayment::with(['student', 'paymentType'])->latest()->take(10)->get();
        $paymentTypes = PaymentType::all();

        return view('finance.dashboard', compact('totalEarnings', 'recentPayments', 'paymentTypes'));
    }

    // የ FS ደረሰኝ ቁጥር ቀደም ሲል መግባቱን መፈተሽ (Check FS Number duplicate)
    public function checkFsNumberExists($fs_number)
    {
        $exists = StudentPayment::where('fs_number', $fs_number)->exists();
        return response()->json(['exists' => $exists]);
    }

    // አዲስ ክፍያ መቀበል
    public function storePayment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'amount_paid' => 'required|numeric|min:1',
            'fs_number' => 'required|string|unique:student_payments,fs_number',
            'ethiopian_month' => 'required|string', // መስከረም፣ ጥቅምት...
            'payment_date' => 'required|string',
            'payment_method' => 'required|in:cash,cbe_birr,telebirr,bank_transfer',
        ]);

        StudentPayment::create([
            'student_id' => $request->student_id,
            'payment_type_id' => $request->payment_type_id,
            'amount_paid' => $request->amount_paid,
            'fs_number' => $request->fs_number,
            'ethiopian_month' => $request->ethiopian_month,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'received_by' => Auth::id(),
            'remark' => $request->remark,
        ]);

        return redirect()->back()->with('success', "ክፍያው በደረሰኝ ቁጥር {$request->fs_number} በተሳካ ሁኔታ ተመዝግቧል!");
    }
}
