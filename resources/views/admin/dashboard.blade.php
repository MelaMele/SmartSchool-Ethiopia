@extends('layouts.app')

@section('title', 'ዋና ዳሽቦርድ')

@section('content')
<div class="space-y-6">
    <!-- ሰላምታ እና መግቢያ -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">እንኳን ደህና መጡ፣ {{ Auth::user()->name }}! 👋</h2>
            <p class="text-sm text-gray-500 mt-1">የዛሬው የትምህርት ቤቱ አጠቃላይ የስራ እንቅስቃሴ ማጠቃለያ።</p>
        </div>
        <a href="{{ route('students.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-lg shadow transition">
            + አዲስ ተማሪ መዝግብ
        </a>
    </div>

    <!-- የስታትስቲክስ ካርዶች (Stat Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg text-2xl">👨‍🎓</div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">ጠቅላላ ተማሪዎች</p>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ \App\Models\Student::count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg text-2xl">🏫</div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">የክፍል ደረጃዎች</p>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ \App\Models\Classes::count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-purple-50 text-purple-600 rounded-lg text-2xl">📚</div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">የትምህርት አይነቶች</p>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ \App\Models\Subject::count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg text-2xl">💰</div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">የተሰበሰበ ገቢ (ETB)</p>
                <h3 class="text-2xl font-extrabold text-gray-800">{{ number_format(\App\Models\StudentPayment::sum('amount_paid'), 2) }} ብር</h3>
            </div>
        </div>
    </div>

    <!-- ፈጣን ተግባራት (Quick Actions) -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">ፈጣን አቋራጭ መንገዶች (Quick Shortcuts)</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('students.index') }}" class="p-4 bg-gray-50 hover:bg-emerald-50 rounded-lg border border-gray-200 text-center transition">
                <span class="block text-2xl mb-1">🗂️</span>
                <span class="font-bold text-sm text-gray-700">የተማሪዎች ማህደር</span>
            </a>
            <a href="{{ route('attendance.index') }}" class="p-4 bg-gray-50 hover:bg-emerald-50 rounded-lg border border-gray-200 text-center transition">
                <span class="block text-2xl mb-1">📅</span>
                <span class="font-bold text-sm text-gray-700">የዕለት አቴንዳንስ</span>
            </a>
            <a href="{{ route('marklist.index') }}" class="p-4 bg-gray-50 hover:bg-emerald-50 rounded-lg border border-gray-200 text-center transition">
                <span class="block text-2xl mb-1">📝</span>
                <span class="font-bold text-sm text-gray-700">ውጤት መመዝገቢያ</span>
            </a>
            <a href="{{ route('finance.dashboard') }}" class="p-4 bg-gray-50 hover:bg-emerald-50 rounded-lg border border-gray-200 text-center transition">
                <span class="block text-2xl mb-1">🧾</span>
                <span class="font-bold text-sm text-gray-700">ደረሰኝ መቁረጫ</span>
            </a>
        </div>
    </div>
</div>
@endsection
