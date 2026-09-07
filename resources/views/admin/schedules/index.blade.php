@extends('layouts.app')

@section('title', 'ክፍለ-ጊዜ መርሃ-ግብር')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">🗓️ ሳምንታዊ የክፍለ-ጊዜ መርሃ-ግብር (Class Timetable)</h2>
            <p class="text-sm text-gray-500">የመምህራን እና የትምህርት ክፍለ-ጊዜዎች ድልድል</p>
        </div>
        <button onclick="window.print()" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-4 py-2 rounded-lg text-sm shadow">
            🖨️ መርሃ-ግብሩን አትም
        </button>
    </div>

    <!-- ክፍል መምረጫ -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <form method="GET" action="{{ route('schedules.index') }}" class="flex items-center space-x-4">
            <div class="flex-1">
                <label class="text-xs font-bold text-gray-600 uppercase">ክፍል ይምረጡ</label>
                <select name="class_id" onchange="this.form.submit()" class="w-full border rounded-lg p-2 text-sm">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>{{ $c->class_label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="text-xs font-bold text-gray-600 uppercase">ሴክሽን ይምረጡ</label>
                <select name="section_id" onchange="this.form.submit()" class="w-full border rounded-lg p-2 text-sm">
                    @foreach($sections as $s)
                        <option value="{{ $s->id }}" {{ $selectedSectionId == $s->id ? 'selected' : '' }}>ሴክሽን {{ $s->section_name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- አዲስ ክፍለ-ጊዜ መመደቢያ ፎርም -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-emerald-800 mb-3 border-b pb-2">+ አዲስ ክፍለ-ጊዜ መድብ</h3>
        <form method="POST" action="{{ route('schedules.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
            @csrf
            <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
            <input type="hidden" name="section_id" value="{{ $selectedSectionId }}">
            <input type="hidden" name="academic_year" value="2016">

            <div>
                <label class="block text-[10px] font-bold text-gray-600 uppercase">ቀን</label>
                <select name="day_of_week" required class="w-full border rounded p-2 text-xs">
                    <option value="monday">ሰኞ (Mon)</option>
                    <option value="tuesday">ማክሰኞ (Tue)</option>
                    <option value="wednesday">ረቡዕ (Wed)</option>
                    <option value="thursday">ሐሙስ (Thu)</option>
                    <option value="friday">ዓርብ (Fri)</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-600 uppercase">ክፍለ-ጊዜ</label>
                <select name="period_number" required class="w-full border rounded p-2 text-xs">
                    @for($i=1; $i<=7; $i++)
                        <option value="{{ $i }}">{{ $i }}ኛ ክፍለ-ጊዜ</option>
                    @endfor
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-[10px] font-bold text-gray-600 uppercase">የትምህርት አይነት</label>
                <select name="subject_id" required class="w-full border rounded p-2 text-xs">
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->subject_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-600 uppercase">መምህር</label>
                <select name="teacher_id" required class="w-full border rounded p-2 text-xs">
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}">{{ optional($t->employee)->full_name ?? 'መምህር #'.$t->id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold p-2 text-xs rounded shadow">
                    መድብ (Assign)
                </button>
            </div>
        </form>
    </div>

    <!-- ሳምንታዊ የመርሃ-ግብር ሰንጠረዥ (Timetable Grid) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-x-auto p-4">
        <table class="w-full border-collapse border border-gray-300 text-center text-xs">
            <thead>
                <tr class="bg-slate-800 text-white font-bold">
                    <th class="border border-gray-300 p-2">ክፍለ-ጊዜ / ሰዓት</th>
                    <th class="border border-gray-300 p-2">ሰኞ (Monday)</th>
                    <th class="border border-gray-300 p-2">ማክሰኞ (Tuesday)</th>
                    <th class="border border-gray-300 p-2">ረቡዕ (Wednesday)</th>
                    <th class="border border-gray-300 p-2">ሐሙስ (Thursday)</th>
                    <th class="border border-gray-300 p-2">ዓርብ (Friday)</th>
                </tr>
            </thead>
            <tbody>
                @for($p = 1; $p <= 7; $p++)
                <tr>
                    <td class="border border-gray-300 p-3 font-bold bg-slate-100">
                        {{ $p }}ኛ ክፍለ-ጊዜ
                    </td>
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                        @php
                            $slot = $schedules->first(function($item) use ($day, $p) {
                                return $item->day_of_week === $day && $item->period_number == $p;
                            });
                        @endphp
                        <td class="border border-gray-300 p-2 text-xs hover:bg-emerald-50 transition">
                            @if($slot)
                                <span class="font-bold text-emerald-900 block">{{ $slot->subject->subject_name }}</span>
                                <span class="text-[10px] text-gray-500 block">{{ optional($slot->teacher->employee)->first_name }}</span>
                            @else
                                <span class="text-gray-300 italic">- ክፍት -</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection
