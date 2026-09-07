@extends('layouts.app')

@section('title', 'የወላጅ ፖርታል')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">እንኳን ደህና መጡ፣ የተከበሩ ወላጅ! 👋</h2>
        <p class="text-sm text-gray-500">የልጆችዎን የትምህርት አፈፃፀም፣ አቴንዳንስ እና የክፍያ ሁኔታ እዚህ ይከታተሉ</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($students as $child)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center space-x-4">
                @if($child->photo)
                    <img src="{{ asset('storage/'.$child->photo) }}" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-500">
                @else
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl">
                        {{ substr($child->first_name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $child->full_name }}</h3>
                    <p class="text-xs text-gray-500">መለያ ቁጥር፦ <span class="font-mono font-bold">{{ $child->student_id }}</span></p>
                    <p class="text-xs bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded inline-block font-semibold mt-1">
                        {{ $child->classes ? $child->classes->class_label : '' }} - ሴክሽን {{ $child->section ? $child->section->section_name : 'A' }}
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-between">
                <a href="{{ route('export.single_id', $child->id) }}" target="_blank" class="text-xs bg-slate-100 text-slate-700 px-3 py-2 rounded-lg font-bold hover:bg-slate-200">
                    🪪 መታወቂያ ይመልከቱ
                </a>
                <a href="{{ route('marklist.report_card', ['student_id' => $child->id, 'semister_id' => 1]) }}" target="_blank" class="text-xs bg-emerald-600 text-white px-3 py-2 rounded-lg font-bold hover:bg-emerald-700">
                    📄 የውጤት ካርድ ይመልከቱ
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-2 bg-white p-8 rounded-xl text-center text-gray-500">
            ከእርስዎ አካውንት ጋር የተሳሰረ የተማሪ መረጃ አልተገኘም። እባክዎ ትምህርት ቤቱን ያነጋግሩ።
        </div>
        @endforelse
    </div>
</div>
@endsection
