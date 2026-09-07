@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden p-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800">🇪🇹 SmartSchool</h1>
        <p class="text-sm text-gray-500 mt-2">የትምህርት ቤት አስተዳደር ሲስተም</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700">ኢሜይል ወይም መለያ ቁጥር</label>
            <input type="text" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="admin@smartschool.et ወይም ADM-001"
                   class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">የይለፍ ቃል (Password)</label>
            <input type="password" name="password" required
                   placeholder="••••••••"
                   class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center text-gray-600">
                <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                <span class="ml-2">አስታውሰኝ</span>
            </label>
        </div>

        <button type="submit"
                class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow-md transition duration-200">
            ግባ (Login)
        </button>
    </form>

    <div class="mt-6 text-center text-xs text-gray-400">
        SmartSchool Ethiopia &copy; {{ date('Y') }}
    </div>
</div>
@endsection
