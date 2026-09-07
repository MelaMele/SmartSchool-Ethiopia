@extends('layouts.app')

@section('title', 'የተማሪዎች ማህደር')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-xl font-bold text-gray-800">የተማሪዎች ማህደር (Students Directory)</h2>
            <p class="text-sm text-gray-500">በትምህርት ቤቱ የተመዘገቡ አጠቃላይ ተማሪዎች ዝርዝር</p>
        </div>
        <a href="{{ route('students.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-lg shadow transition">
            + አዲስ ተማሪ መዝግብ
        </a>
    </div>

    <!-- የተማሪዎች ሰንጠረዥ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-200 text-xs font-bold text-gray-600 uppercase">
                        <th class="p-4">ፎቶ</th>
                        <th class="p-4">የተማሪ መታወቂያ</th>
                        <th class="p-4">ሙሉ ስም</th>
                        <th class="p-4">ክፍል / ሴክሽን</th>
                        <th class="p-4">ጾታ</th>
                        <th class="p-4">ሁኔታ</th>
                        <th class="p-4 text-center">ተግባራት</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4">
                            @if($student->photo)
                                <img src="{{ asset('storage/'.$student->photo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200" alt="Photo">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold">
                                    {{ substr($student->first_name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="p-4 font-mono font-bold text-emerald-700">{{ $student->student_id }}</td>
                        <td class="p-4 font-bold text-gray-800">{{ $student->full_name }}</td>
                        <td class="p-4">
                            <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded text-xs font-semibold">
                                {{ $student->classes ? $student->classes->class_label : 'ያልተመደበ' }}
                                {{ $student->section ? '- ' . $student->section->section_name : '' }}
                            </span>
                        </td>
                        <td class="p-4 capitalize text-gray-600">{{ $student->gender === 'male' ? 'ወንድ' : 'ሴት' }}</td>
                        <td class="p-4">
                            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full text-xs font-bold">ንቁ (Active)</span>
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('export.single_id', $student->id) }}" target="_blank" class="text-xs bg-indigo-50 text-indigo-700 px-2.5 py-1.5 rounded hover:bg-indigo-100 font-bold" title="መታወቂያ ካርድ አትም">
                                🪪 መታወቂያ
                            </a>
                            <a href="{{ route('students.show', $student->id) }}" class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1.5 rounded hover:bg-gray-200 font-bold">
                                ዝርዝር
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400">
                            ምንም የተመዘገበ ተማሪ አልተገኘም።
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
