@extends('layouts.app')

@section('title', 'የተማሪ ዝርዝር መረጃ')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 bg-emerald-100 text-emerald-800 rounded-full flex items-center justify-center font-bold text-xl">
                {{ substr($student->first_name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $student->full_name }}</h2>
                <p class="text-xs text-gray-500">መለያ ቁጥር፦ <span class="font-mono font-bold">{{ $student->student_id }}</span> | ክፍል፦ {{ $student->classes ? $student->classes->class_label : '' }}</p>
            </div>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-gray-800">← ተመለስ</a>
    </div>

    <!-- የውጤት እና አቴንዳንስ አቋራጮች -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 text-md mb-2">📄 ይፋዊ የውጤት ካርድ</h3>
            <p class="text-xs text-gray-500 mb-4">የሴሚስተሩን ሙሉ የፈተና ውጤት፣ አማካይ እና ደረጃ ይመልከቱ</p>
            <a href="{{ route('marklist.report_card', ['student_id' => $student->id, 'semister_id' => 1]) }}" target="_blank" class="inline-block bg-emerald-600 text-white font-bold text-xs px-4 py-2 rounded-lg shadow">
                የውጤት ካርድ ክፈት →
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 text-md mb-2">📖 የግንኙነት ደብተር</h3>
            <p class="text-xs text-gray-500 mb-4">ከመምህራን የተላኩ የቤት ስራዎችን እና የስነ-ምግባር ማስታወሻዎችን ይመልከቱ</p>
            <a href="{{ route('communication.index', $student->id) }}" class="inline-block bg-slate-800 text-white font-bold text-xs px-4 py-2 rounded-lg shadow">
                ደብተሩን ክፈት →
            </a>
        </div>
    </div>
</div>
@endsection
