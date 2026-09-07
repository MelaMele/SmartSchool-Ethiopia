@extends('layouts.app')

@section('title', 'የዕለት አቴንዳንስ')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">የተማሪዎች የዕለት ክትትል (Attendance)</h2>
        <p class="text-sm text-gray-500">ክፍል እና ቀን በመምረጥ የተማሪዎችን አቴንዳንስ ይመዝግቡ</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('attendance.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የክፍል ደረጃ *</label>
                    <select name="class_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ሴክሽን *</label>
                    <select name="section_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                        @foreach(\App\Models\Section::all() as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ቀን (በኢትዮጵያ ዓ.ም) *</label>
                    <input type="text" name="attendance_date" value="2016-01-15" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
            </div>

            <!-- የተማሪዎች አቴንዳንስ ሰንጠረዥ -->
            <div class="border rounded-xl overflow-hidden mt-6">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase border-b">
                        <tr>
                            <th class="p-3">መለያ</th>
                            <th class="p-3">የተማሪ ስም</th>
                            <th class="p-3 text-center">ተገኝቷል (Present)</th>
                            <th class="p-3 text-center">ቀሪ (Absent)</th>
                            <th class="p-3 text-center">ዘግይቷል (Late)</th>
                            <th class="p-3 text-center">ፈቃድ (Permission)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach(\App\Models\Student::take(10)->get() as $student)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono font-bold text-emerald-800">{{ $student->student_id }}</td>
                            <td class="p-3 font-bold">{{ $student->full_name }}</td>
                            <td class="p-3 text-center">
                                <input type="radio" name="attendance[{{ $student->id }}]" value="present" checked class="text-emerald-600 focus:ring-emerald-500">
                            </td>
                            <td class="p-3 text-center">
                                <input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="text-red-600 focus:ring-red-500">
                            </td>
                            <td class="p-3 text-center">
                                <input type="radio" name="attendance[{{ $student->id }}]" value="late" class="text-amber-600 focus:ring-amber-500">
                            </td>
                            <td class="p-3 text-center">
                                <input type="radio" name="attendance[{{ $student->id }}]" value="permission" class="text-blue-600 focus:ring-blue-500">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg shadow">
                    አቴንዳንስ መዝግብ (Save Attendance)
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
