@extends('layouts.app')

@section('title', 'የተጠቃሚዎች አስተዳደር')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">👥 የተጠቃሚዎች እና ፈቃዶች አስተዳደር (User Management)</h2>
            <p class="text-sm text-gray-500">ለመምህራን፣ ለወላጆች እና ለሰራተኞች አካውንት መስጫ እና መቆጣጠሪያ ማዕከል</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- 1. አዲስ ተጠቃሚ / መምህር መመዝገቢያ ፎርም -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
            <h3 class="text-md font-bold text-emerald-800 mb-4 border-b pb-2">+ አዲስ አካውንት ፍጠር</h3>
            <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ሙሉ ስም *</label>
                    <input type="text" name="name" required placeholder="መምህር ግርማ በቀለ" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ኢሜይል *</label>
                    <input type="email" name="email" required placeholder="girma@smartschool.et" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የመለያ ቁጥር (User ID) *</label>
                    <input type="text" name="user_id" required placeholder="TCH-002" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ሚና (Role) *</label>
                    <select name="role_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }} ({{ $role->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የይለፍ ቃል (Password) *</label>
                    <input type="password" name="password" required placeholder="••••••••" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg shadow transition text-sm">
                    አካውንቱን ፍጠር (Create Account)
                </button>
            </form>
        </div>

        <!-- 2. የተመዘገቡ ተጠቃሚዎች ዝርዝር -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <h3 class="text-md font-bold text-gray-800 p-4 border-b">የትምህርት ቤቱ ተጠቃሚዎች ዝርዝር</h3>
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase border-b">
                    <tr>
                        <th class="p-3">ተጠቃሚ</th>
                        <th class="p-3">መለያ</th>
                        <th class="p-3">ሚና (Role)</th>
                        <th class="p-3">ሁኔታ</th>
                        <th class="p-3 text-center">መቆጣጠሪያ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($users as $u)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3">
                            <p class="font-bold text-gray-800">{{ $u->name }}</p>
                            <p class="text-xs text-gray-400">{{ $u->email }}</p>
                        </td>
                        <td class="p-3 font-mono text-emerald-800 font-bold text-xs">{{ $u->user_id ?? '---' }}</td>
                        <td class="p-3">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                {{ optional($u->role)->name === 'admin' ? 'bg-rose-100 text-rose-800' : '' }}
                                {{ optional($u->role)->name === 'teacher' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ optional($u->role)->name === 'finance' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ optional($u->role)->name === 'parent' ? 'bg-emerald-100 text-emerald-800' : '' }}">
                                {{ optional($u->role)->display_name ?? 'ተጠቃሚ' }}
                            </span>
                        </td>
                        <td class="p-3">
                            @if($u->is_active)
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">ንቁ (Active)</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded-full">የታገደ (Blocked)</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('users.toggle_status', $u->id) }}">
                                @csrf
                                <button type="submit" class="text-xs px-2.5 py-1 rounded font-bold transition
                                    {{ $u->is_active ? 'bg-rose-50 text-rose-600 hover:bg-rose-100' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                                    {{ $u->is_active ? '🚫 እገድ' : '✓ አንሳ' }}
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400 italic">ዋና አድሚን</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t">{{ $users->links() }}</div>
        </div>
    </div>
</div>
@endsection
