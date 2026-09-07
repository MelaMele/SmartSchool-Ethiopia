@extends('layouts.app')

@section('title', 'አዲስ ተማሪ መዝግብ')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">አዲስ ተማሪ መመዝገቢያ ቅጽ</h2>
            <p class="text-sm text-gray-500">የተማሪውን፣ የወላጁን እና የአድራሻ መረጃዎችን በትክክል ያስገቡ</p>
        </div>
        <a href="{{ route('students.index') }}" class="text-sm font-bold text-gray-600 hover:text-gray-800">← ተመለስ</a>
    </div>

    <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- 1. የተማሪው የግል መረጃ -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
            <h3 class="text-md font-bold text-emerald-800 border-b pb-2">1. የተማሪው የግል መረጃ</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የተማሪው ስም *</label>
                    <input type="text" name="first_name" required placeholder="ዮሐንስ" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የአባት ስም *</label>
                    <input type="text" name="middle_name" required placeholder="ተስፋዬ" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የአያት ስም *</label>
                    <input type="text" name="last_name" required placeholder="ከበደ" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ጾታ *</label>
                    <select name="gender" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="male">ወንድ</option>
                        <option value="female">ሴት</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የትውልድ ቀን (ዓ.ም)</label>
                    <input type="text" name="birth_date" placeholder="12/05/2008" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የተማሪው ፎቶ</label>
                    <input type="file" name="photo" accept="image/*" class="mt-1 w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የክፍል ደረጃ *</label>
                    <select name="class_id" required class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የትምህርት ዘርፍ (Stream)</label>
                    <select name="stream_id" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="">ምንም</option>
                        @foreach($streams as $stream)
                            <option value="{{ $stream->id }}">{{ $stream->stream_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ሴክሽን (አማራጭ)</label>
                    <select name="section_id" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="">በኋላ ይመደባል</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- 2. የወላጅ / አሳዳጊ መረጃ -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
            <h3 class="text-md font-bold text-emerald-800 border-b pb-2">2. የወላጅ / አሳዳጊ መረጃ</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የአባት ሙሉ ስም</label>
                    <input type="text" name="father_name" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የአባት ስልክ ቁጥር</label>
                    <input type="text" name="father_phone" placeholder="0911000000" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የአባት የስራ ዘርፍ</label>
                    <input type="text" name="father_occupation" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
            </div>
        </div>

        <!-- 3. የመኖሪያ አድራሻ -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
            <h3 class="text-md font-bold text-emerald-800 border-b pb-2">3. የመኖሪያ አድራሻ</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ክፍለ ከተማ</label>
                    <input type="text" name="subcity" placeholder="ቦሌ" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ወረዳ</label>
                    <input type="text" name="woreda" placeholder="03" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">ቀበሌ / የቤት ቁጥር</label>
                    <input type="text" name="house_number" placeholder="1044" class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase">የአደጋ ጊዜ ስልክ</label>
                    <input type="text" name="phone_number" placeholder="09..." class="mt-1 w-full border border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow transition">
                ተማሪውን መዝግብ (Save Student)
            </button>
        </div>
    </form>
</div>
@endsection
