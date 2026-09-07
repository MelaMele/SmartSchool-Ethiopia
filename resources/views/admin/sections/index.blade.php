@extends('layouts.app')

@section('title', 'ሴክሽኖች')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">🗂️ ሴክሽኖች እና ተማሪዎችን መመደቢያ (Sections)</h2>
            <p class="text-sm text-gray-500">ክፍሎችን ወደ ሴክሽን (A, B, C...) መክፈያ እና ተማሪዎችን በራስ-ሰር ማከፋፈያ</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- አዲስ ሴክሽን መፍጠሪያ -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit space-y-6">
            <div>
                <h3 class="text-md font-bold text-emerald-800 mb-3 border-b pb-2">+ አዲስ ሴክሽን ፍጠር</h3>
                <form method="POST" action="{{ route('sections.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase">ክፍል ይምረጡ *</label>
                        <select name="class_id" required class="w-full border rounded p-2 text-sm">
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->class_label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase">የሴክሽኑ ስም *</label>
                        <input type="text" name="section_name" required placeholder="A ወይም B" class="w-full border rounded p-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase">የክፍሉ የመያዝ አቅም (Capacity) *</label>
                        <input type="number" name="capacity" value="40" required class="w-full border rounded p-2 text-sm">
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded text-sm shadow">
                        ሴክሽኑን ፍጠር
                    </button>
                </form>
            </div>

            <!-- በራስ-ሰር ተማሪዎችን መመደቢያ (Smart Auto-Assign) -->
            <div class="pt-4 border-t border-gray-100">
                <h3 class="text-xs font-bold text-purple-900 uppercase mb-2">⚡ ተማሪዎችን በራስ-ሰር መድብ</h3>
                <form method="POST" action="{{ route('sections.auto_assign') }}">
                    @csrf
                    <select name="class_id" required class="w-full border rounded p-2 text-xs mb-2">
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->class_label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 rounded text-xs shadow">
                        ተማሪዎችን በእኩል አከፋፍል
                    </button>
                </form>
            </div>
        </div>

        <!-- የሴክሽኖች ዝርዝር -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 text-xs font-bold text-gray-600 uppercase border-b">
                    <tr>
                        <th class="p-3">ክፍል</th>
                        <th class="p-3">ሴክሽን</th>
                        <th class="p-3">አቅም</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($sections as $section)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold text-emerald-800">{{ $section->classes ? $section->classes->class_label : '' }}</td>
                        <td class="p-3 font-bold">ሴክሽን {{ $section->section_name }}</td>
                        <td class="p-3 text-gray-600">{{ $section->capacity }} ተማሪዎች</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-6 text-center text-gray-400">ምንም ሴክሽን አልተገኘም።</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
