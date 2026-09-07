@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden p-8">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-black text-slate-800">🇪🇹 SmartSchool</h1>
        <p class="text-sm font-semibold text-emerald-700 mt-1">የትምህርት ዘመን፦ 2019 ዓ.ም</p>
        <p class="text-xs text-gray-400 mt-0.5">የትምህርት ቤት አስተዳደር ሲስተም</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase">ኢሜይል ወይም መለያ ቁጥር</label>
            <input type="text" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="admin@smartschool.et ወይም ADM-001"
                   class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase">የይለፍ ቃል (Password)</label>
            <input type="password" name="password" required
                   placeholder="••••••••"
                   class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm">
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center text-gray-600">
                <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                <span class="ml-2 font-medium">አስታውሰኝ</span>
            </label>
        </div>

        <button type="submit"
                class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow-md transition duration-200 text-sm">
            ግባ (Login)
        </button>
    </form>

    <!-- Mela Solution Branding -->
    <div class="mt-8 pt-4 border-t border-gray-100 text-center space-y-1">
        <p class="text-xs text-gray-500">
            Powered by <strong class="text-emerald-700 font-bold">Mela Solution</strong>
        </p>
        <p class="text-[11px] text-gray-400 font-mono">
            📞 0913064239 / 0703064239
        </p>
    </div>
</div>
@endsection
