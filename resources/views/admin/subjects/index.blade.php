@extends('layouts.app')

@section('title', 'የትምህርት አይነቶች')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">📚 የትምህርት አይነቶች (Subjects)</h2>
            <p class="text-sm text-gray-500">በትምህርት ቤቱ የሚሰጡ አጠቃላይ የትምህርት አይነቶች ዝርዝር</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- አዲስ ትምህርት መመዝገቢያ -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
            <h3 class="text-md font-bold text-emerald-800 mb-4 border-b pb-2">+ አዲስ የትምህርት አይነት</h3>
            <form method="POST" action="{{ route('subjects.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የትምህርቱ ስም *</label>
                    <input type="text" name="subject_name" required placeholder="ለምሳሌ፡ Mathematics" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ኮድ (Code)</label>
                    <input type="text" name="subject_code" placeholder="MATH" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg shadow transition">
                    ትምህርቱን መዝግብ
                </button>
            </form>
        </div>

        <!-- ዝርዝር ሰንጠረዥ -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase border-b">
                    <tr>
                        <th class="p-3">ኮድ</th>
                        <th class="p-3">የትምህርቱ ስም</th>
                        <th class="p-3 text-center">ተግባራት</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($subjects as $subject)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-mono font-bold text-emerald-800">{{ $subject->subject_code ?? '---' }}</td>
                        <td class="p-3 font-bold text-gray-800">{{ $subject->subject_name }}</td>
                        <td class="p-3 text-center">
                            <form method="POST" action="{{ route('subjects.destroy', $subject->id) }}" onsubmit="return confirm('ይህ የትምህርት አይነት ይሰረዝ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold">ሰርዝ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-6 text-center text-gray-400">ምንም የትምህርት አይነት አልተገኘም።</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
