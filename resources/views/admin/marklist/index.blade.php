@extends('layouts.app')

@section('title', 'የውጤት መመዝገቢያ')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">የፈተና እና የምዘና ውጤት መመዝገቢያ</h2>
        <p class="text-sm text-gray-500">ክፍል፣ የትምህርት አይነት እና የፈተናውን አይነት በመምረጥ የተማሪዎችን ውጤት ያስገቡ</p>
    </div>

    <!-- የመምረጫ ፎርም -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('marklist.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የክፍል ደረጃ *</label>
                    <select name="class_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የትምህርት አይነት *</label>
                    <select name="subject_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ሴሚስተር / ሩብ ዓመት *</label>
                    <select name="semister_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        @foreach($semisters as $semister)
                            <option value="{{ $semister->id }}">{{ $semister->semister_name }} ({{ $semister->academic_year }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የፈተና አይነት *</label>
                    <select name="assasment_type_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        @foreach($assessments as $assessment)
                            <option value="{{ $assessment->id }}">{{ $assessment->assasment_type }} (ክብደት፦ {{ $assessment->weight }}%)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- ተማሪዎች እና ውጤት ማስገቢያ ሰንጠረዥ -->
            <div class="border rounded-xl overflow-hidden mt-6">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase border-b">
                        <tr>
                            <th class="p-3">ተማሪ መታወቂያ</th>
                            <th class="p-3">ሙሉ ስም</th>
                            <th class="p-3 w-48">ውጤት (Mark)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @foreach(\App\Models\Student::take(10)->get() as $student)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono font-bold text-emerald-800">{{ $student->student_id }}</td>
                            <td class="p-3 font-bold">{{ $student->full_name }}</td>
                            <td class="p-3">
                                <input type="number" step="0.01" max="100" min="0" name="marks[{{ $student->id }}]"
                                       placeholder="100%" class="w-full border border-gray-300 rounded p-1.5 text-sm focus:ring-2 focus:ring-emerald-500">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg shadow">
                    ውጤቱን መዝግብ (Save Marks)
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
