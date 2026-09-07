@extends('layouts.app')

@section('title', 'ፋይናንስ ዳሽቦርድ')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-xl font-bold text-gray-800">የሂሳብ እና ክፍያ ክፍል (Finance & Cashier)</h2>
            <p class="text-sm text-gray-500">የትምህርት፣ የምዝገባ እና የትራንስፖርት ክፍያዎች መቀበያ</p>
        </div>
        <div class="text-right">
            <span class="text-xs text-gray-500 uppercase font-bold">ጠቅላላ የተሰበሰበ ገቢ</span>
            <p class="text-2xl font-black text-emerald-700">{{ number_format($totalEarnings, 2) }} ብር</p>
        </div>
    </div>

    <!-- አዲስ ክፍያ መቀበያ ፎርም -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-md font-bold text-emerald-800 mb-4 border-b pb-2">🧾 አዲስ ደረሰኝ መቁረጥ (Receive Payment)</h3>

        <form method="POST" action="{{ route('finance.payments.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ተማሪ ይምረጡ *</label>
                    <select name="student_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                        @foreach(\App\Models\Student::all() as $student)
                            <option value="{{ $student->id }}">{{ $student->student_id }} - {{ $student->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የክፍያ አይነት *</label>
                    <select name="payment_type_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                        @foreach($paymentTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->payment_type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የክፍያ ወር (የኢትዮጵያ ወራት) *</label>
                    <select name="ethiopian_month" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                        @foreach(['መስከረም', 'ጥቅምት', 'ኅዳር', 'ታኅሣሥ', 'ጥር', 'የካቲት', 'መጋቢት', 'ሚያዝያ', 'ግንቦት', 'ሰኔ', 'ሐምሌ', 'ነሐሴ'] as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የ FS ደረሰኝ ቁጥር *</label>
                    <input type="text" name="fs_number" required placeholder="FS-908231" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm font-mono">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የተከፈለ መጠን (ብር) *</label>
                    <input type="number" step="0.01" name="amount_paid" required placeholder="2500.00" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የክፍያ ዘዴ *</label>
                    <select name="payment_method" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                        <option value="cash">በጥሬ ገንዘብ (Cash)</option>
                        <option value="telebirr">ቴሌብር (Telebirr)</option>
                        <option value="cbe_birr">ሲቢኢ ብር (CBE Birr)</option>
                        <option value="bank_transfer">በባንክ ዝውውር</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የተከፈለበት ቀን *</label>
                    <input type="text" name="payment_date" value="2016-01-15" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg shadow">
                    ክፍያውን መዝግብ (Submit Payment)
                </button>
            </div>
        </form>
    </div>

    <!-- የቅርብ ጊዜ የተቆረጡ ደረሰኞች -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <h3 class="text-md font-bold text-gray-800 p-4 border-b">የቅርብ ጊዜ ደረሰኞች (Recent Transactions)</h3>
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase">
                <tr>
                    <th class="p-3">FS ቁጥር</th>
                    <th class="p-3">ተማሪ</th>
                    <th class="p-3">የክፍያ አይነት</th>
                    <th class="p-3">ወር</th>
                    <th class="p-3">መጠን (ብር)</th>
                    <th class="p-3">ዘዴ</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($recentPayments as $payment)
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-mono font-bold text-indigo-700">{{ $payment->fs_number }}</td>
                    <td class="p-3 font-bold">{{ $payment->student ? $payment->student->full_name : '' }}</td>
                    <td class="p-3">{{ $payment->paymentType ? $payment->paymentType->payment_type_name : '' }}</td>
                    <td class="p-3">{{ $payment->ethiopian_month }}</td>
                    <td class="p-3 font-bold text-emerald-700">{{ number_format($payment->amount_paid, 2) }}</td>
                    <td class="p-3 capitalize">{{ $payment->payment_method }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-4 text-center text-gray-400">ምንም የክፍያ መረጃ የለም።</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
