@extends('layouts.app')

@section('title', 'የመምህራን ዳሽቦርድ')

@section('content')
<div class="space-y-6">
    <!-- ሰላምታ -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">እንኳን ደህና መጡ፣ {{ Auth::user()->name }}! 👨‍🏫</h2>
            <p class="text-sm text-gray-500 mt-1">የመምህራን ፖርታል - የውጤት፣ የአቴንዳንስ እና የተማሪዎች ክትትል ማዕከል</p>
        </div>
        <span class="bg-emerald-100 text-emerald-800 text-xs px-3 py-1.5 rounded-full font-bold">
            መምህር (Teacher Portal)
        </span>
    </div>

    <!-- የመምህሩ ፈጣን ስታቲስቲክስ -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg text-2xl">🏫</div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">የማስተምራቸው ክፍሎች</p>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ \App\Models\Classes::count() }} ክፍሎች</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg text-2xl">👨‍🎓</div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">ጠቅላላ ተማሪዎች</p>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ \App\Models\Student::count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-purple-50 text-purple-600 rounded-lg text-2xl">📚</div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">የትምህርት አይነቶች</p>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ \App\Models\Subject::count() }}</h3>
            </div>
        </div>
    </div>

    <!-- የመምህሩ ዋና ዋና ተግባራት (Teacher Actions) -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">የመምህሩ የስራ ማዕከል</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <a href="{{ route('marklist.index') }}" class="p-5 bg-slate-50 hover:bg-emerald-50 rounded-xl border border-gray-200 transition flex items-center space-x-4">
                <div class="text-3xl">📝</div>
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">የፈተና ውጤት መመዝገቢያ</h4>
                    <p class="text-xs text-gray-500 mt-0.5">የፈተና፣ ኩዊዝ እና አሳይመንት ውጤት ሙላ</p>
                </div>
            </a>

            <a href="{{ route('attendance.index') }}" class="p-5 bg-slate-50 hover:bg-emerald-50 rounded-xl border border-gray-200 transition flex items-center space-x-4">
                <div class="text-3xl">📅</div>
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">የዕለት አቴንዳንስ መመዝገቢያ</h4>
                    <p class="text-xs text-gray-500 mt-0.5">የተማሪዎችን የቀሪነት እና ፈቃድ ሁኔታ መዝግብ</p>
                </div>
            </a>

            <a href="{{ route('students.index') }}" class="p-5 bg-slate-50 hover:bg-emerald-50 rounded-xl border border-gray-200 transition flex items-center space-x-4">
                <div class="text-3xl">📖</div>
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">የተማሪዎች የግንኙነት ደብተር</h4>
                    <p class="text-xs text-gray-500 mt-0.5">ለወላጆች የቤት ስራ እና ማስታወሻ ጻፍ</p>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection
