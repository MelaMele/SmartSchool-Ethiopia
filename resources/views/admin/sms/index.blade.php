@extends('layouts.app')

@section('title', 'SMS መልዕክት መላኪያ')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">📱 የ SMS መልዕክት መላኪያ (SMS Broadcast)</h2>
            <p class="text-sm text-gray-500">ለወላጆች በስልካቸው አጭር የጽሁፍ መልዕክት በጅምላ መላኪያ ማዕከል</p>
        </div>
        <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-full">
            Ethio Telecom / AfroMessage API Ready
        </span>
    </div>

    <!-- መልዕክት መላኪያ ፎርም -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('sms.send_bulk') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ተቀባዮችን ይምረጡ *</label>
                    <select name="target" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="all">👨‍👩‍👧 ለሁሉም ተማሪ ወላጆች</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">ለ {{ $class->class_label }} ወላጆች ብቻ</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase">የመልዕክቱ ይዘት (SMS Message) *</label>
                    <textarea name="message" rows="3" maxlength="160" required
                              placeholder="ውድ ወላጅ፡ ነገ ማክሰኞ የትምህርት ቤቱ የወላጆች ስብሰባ ስላለ በሰዓቱ እንዲገኙ በትህትና እናሳስባለን።"
                              class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm"></textarea>
                    <p class="text-[10px] text-gray-400 mt-1">ከፍተኛው የፊደላት ብዛት፦ 160 ፊደላት (1 SMS)</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg shadow transition">
                    🚀 መልዕክቱን ላክ (Broadcast SMS)
                </button>
            </div>
        </form>
    </div>

    <!-- የተላኩ መልዕክቶች መዝገብ (SMS Logs) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <h3 class="text-md font-bold text-gray-800 p-4 border-b">የቅርብ ጊዜ የተላኩ መልዕክቶች (SMS History)</h3>
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase border-b">
                <tr>
                    <th class="p-3">ስልክ ቁጥር</th>
                    <th class="p-3">ተማሪ</th>
                    <th class="p-3">መልዕክት</th>
                    <th class="p-3">አይነት</th>
                    <th class="p-3">ሁኔታ</th>
                    <th class="p-3">የተላከበት ሰዓት</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-mono font-bold text-emerald-800">{{ $log->phone_number }}</td>
                    <td class="p-3 font-semibold">{{ $log->student ? $log->student->full_name : 'አጠቃላይ' }}</td>
                    <td class="p-3 text-xs text-gray-600 max-w-xs truncate">{{ $log->message }}</td>
                    <td class="p-3 capitalize text-xs">{{ $log->type }}</td>
                    <td class="p-3">
                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ $log->status }}
                        </span>
                    </td>
                    <td class="p-3 text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-6 text-center text-gray-400">ምንም የተላከ መልዕክት የለም።</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-gray-100">{{ $logs->links() }}</div>
    </div>
</div>
@endsection
