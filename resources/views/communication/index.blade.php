@extends('layouts.app')

@section('title', 'የግንኙነት ደብተር')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">📖 የተማሪ የግንኙነት ደብተር (Communication Book)</h2>
            <p class="text-sm text-gray-500">የተማሪ፦ <span class="font-bold text-emerald-800">{{ $student->full_name }}</span> ({{ $student->student_id }})</p>
        </div>
        <a href="javascript:history.back()" class="text-sm font-bold text-gray-600 hover:text-gray-800">← ተመለስ</a>
    </div>

    <!-- 1. መምህሩ ማስታወሻ የሚጽፍበት ፎርም (ለመምህራን እና ለአድሚን ብቻ የሚታይ) -->
    @if(Auth::user()->role && in_array(Auth::user()->role->name, ['admin', 'teacher']))
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-md font-bold text-emerald-800 mb-4 border-b pb-2">✍️ አዲስ ማስታወሻ / የቤት ስራ ጻፍ</h3>
        <form method="POST" action="{{ route('communication.store', $student->id) }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የመልዕክት አይነት *</label>
                    <select name="type" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="homework">📚 የቤት ስራ (Homework)</option>
                        <option value="conduct">⚠️ የስነ-ምግባር ማስታወሻ (Conduct)</option>
                        <option value="notice">📢 አጠቃላይ ማስታወቂያ (Notice)</option>
                        <option value="appreciation">🌟 የምስጋና መልዕክት (Appreciation)</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase">ርዕስ *</label>
                    <input type="text" name="title" required placeholder="ለምሳሌ፡ የሂሳብ የቤት ስራ ገጽ 45" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase">ዝርዝር መልዕክት *</label>
                <textarea name="message" rows="3" required placeholder="የመልዕክቱን ዝርዝር እዚህ ይጻፉ..." class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm"></textarea>
            </div>

            <div class="flex justify-between items-center">
                <input type="hidden" name="date" value="2016-01-20">
                <span class="text-xs text-gray-400">ቀን፦ 2016 ዓ.ም</span>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2 rounded-lg shadow transition">
                    መልዕክቱን ላክ (Post Note)
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- 2. ያለፉ መልዕክቶች እና የወላጅ ማረጋገጫ ዝርዝር (Timeline) -->
    <div class="space-y-4">
        <h3 class="text-lg font-bold text-gray-800">የቀደሙ መልዕክቶች ዝርዝር</h3>
        @forelse($entries as $entry)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-3">
            <div class="flex justify-between items-start">
                <div class="flex items-center space-x-2">
                    @if($entry->type === 'homework')
                        <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded font-bold">📚 የቤት ስራ</span>
                    @elseif($entry->type === 'conduct')
                        <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded font-bold">⚠️ ስነ-ምግባር</span>
                    @elseif($entry->type === 'appreciation')
                        <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded font-bold">🌟 ምስጋና</span>
                    @else
                        <span class="bg-purple-100 text-purple-800 text-xs px-2.5 py-1 rounded font-bold">📢 ማስታወቂያ</span>
                    @endif
                    <h4 class="font-bold text-gray-800">{{ $entry->title }}</h4>
                </div>
                <span class="text-xs text-gray-400 font-mono">{{ $entry->date }}</span>
            </div>

            <p class="text-sm text-gray-600 bg-slate-50 p-3 rounded-lg">{{ $entry->message }}</p>

            <!-- የወላጅ ማረጋገጫ ክፍል -->
            <div class="pt-3 border-t border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-2">
                <div>
                    @if($entry->is_acknowledged)
                        <span class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full font-bold">
                            ✓ በወላጅ ታይቶ ተረጋግጧል (Acknowledged)
                        </span>
                        @if($entry->parent_reply)
                            <p class="text-xs text-gray-500 mt-1 italic">የወላጅ አስተያየት፦ "{{ $entry->parent_reply }}"</p>
                        @endif
                    @else
                        <span class="text-xs bg-rose-50 text-rose-700 px-3 py-1 rounded-full font-bold">
                            ⏳ በወላጅ ገና አልታየም
                        </span>
                    @endif
                </div>

                <!-- ወላጁ ማረጋገጫ የሚሰጥበት ቁልፍ -->
                @if(Auth::user()->role && Auth::user()->role->name === 'parent' && !$entry->is_acknowledged)
                <form method="POST" action="{{ route('communication.acknowledge', $entry->id) }}" class="flex items-center space-x-2">
                    @csrf
                    <input type="text" name="parent_reply" placeholder="አስተያየት (አማራጭ)" class="text-xs border rounded px-2 py-1">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1 rounded shadow">
                        አይቻለሁ / አረጋግጥ
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white p-8 rounded-xl text-center text-gray-400">
            ምንም የተመዘገበ መልዕክት የለም።
        </div>
        @endforelse

        <div>{{ $entries->links() }}</div>
    </div>
</div>
@endsection
