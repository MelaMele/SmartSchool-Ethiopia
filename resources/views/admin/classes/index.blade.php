@extends('layouts.app')

@section('title', 'የክፍል ደረጃዎች')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">🏫 የክፍል ደረጃዎች አስተዳደር (Classes)</h2>
            <p class="text-sm text-gray-500">በትምህርት ቤቱ ያሉ የክፍል ደረጃዎች (ከመዋዕለ-ህፃናት እስከ 12ኛ ክፍል)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- አዲስ ክፍል መመዝገቢያ ፎርም -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
            <h3 class="text-md font-bold text-emerald-800 mb-4 border-b pb-2">+ አዲስ ክፍል ጨምር</h3>
            <form method="POST" action="{{ route('classes.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የክፍሉ ስም *</label>
                    <input type="text" name="class_label" required placeholder="ለምሳሌ፡ Grade 9" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ቅድሚያ ቅደም ተከተል (Priority) *</label>
                    <input type="number" name="priority" required placeholder="12" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg shadow transition">
                    ክፍሉን መዝግብ
                </button>
            </form>
        </div>

        <!-- የክፍሎች ዝርዝር ሰንጠረዥ -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase border-b">
                    <tr>
                        <th class="p-3">ቅደም ተከተል</th>
                        <th class="p-3">የክፍሉ ስም</th>
                        <th class="p-3">ሴክሽኖች</th>
                        <th class="p-3 text-center">ተግባራት</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($classes as $class)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-mono font-bold text-emerald-800">#{{ $class->priority }}</td>
                        <td class="p-3 font-bold text-gray-800">{{ $class->class_label }}</td>
                        <td class="p-3">
                            <span class="bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded text-xs font-semibold">
                                {{ $class->sections->count() }} ሴክሽኖች
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <form method="POST" action="{{ route('classes.destroy', $class->id) }}" onsubmit="return confirm('እርግጠኛ ነዎት ይህ ክፍል ይሰረዝ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold">ሰርዝ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-6 text-center text-gray-400">ምንም የተመዘገበ ክፍል የለም።</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
