<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>የተማሪ መታወቂያ - {{ $student->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-200 flex flex-col items-center justify-center min-h-screen p-4">

    <div class="no-print mb-4">
        <button onclick="window.print()" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold shadow hover:bg-emerald-700">
            🖨️ መታወቂያውን አትም (Print ID Card)
        </button>
    </div>

    <!-- የመታወቂያው ካርድ (ID Card Design - 85mm x 54mm Standard) -->
    <div class="w-[340px] h-[215px] bg-white rounded-xl shadow-2xl border-2 border-emerald-700 overflow-hidden relative flex flex-col justify-between p-3 bg-gradient-to-b from-emerald-50 via-white to-white">
        
        <!-- ራስጌ (Header) -->
        <div class="text-center border-b border-emerald-600 pb-1 flex items-center justify-between">
            <div class="text-left">
                <h1 class="text-xs font-black text-emerald-950 uppercase tracking-tight">SMARTSCHOOL ETHIOPIA</h1>
                <p class="text-[8px] text-gray-500">የተማሪ መታወቂያ ካርድ / STUDENT ID CARD</p>
            </div>
            <span class="text-lg">🇪🇹</span>
        </div>

        <!-- መካከለኛ አካል (Body) -->
        <div class="flex items-center space-x-3 my-auto">
            <!-- ፎቶ -->
            <div class="w-20 h-24 bg-gray-100 border border-emerald-600 rounded overflow-hidden flex-shrink-0">
                @if($student->photo)
                    <img src="{{ asset('storage/'.$student->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold">ፎቶ የለም</div>
                @endif
            </div>

            <!-- የተማሪው ዝርዝር -->
            <div class="text-[10px] space-y-1 text-gray-800 flex-1">
                <p><span class="font-bold text-gray-500">መለያ ቁጥር:</span> <span class="font-mono font-bold text-emerald-800">{{ $student->student_id }}</span></p>
                <p><span class="font-bold text-gray-500">ስም:</span> <span class="font-bold">{{ $student->full_name }}</span></p>
                <p><span class="font-bold text-gray-500">ክፍል:</span> <span class="font-bold">{{ $student->classes ? $student->classes->class_label : '' }} {{ $student->section ? '('.$student->section->section_name.')' : '' }}</span></p>
                <p><span class="font-bold text-gray-500">ጾታ:</span> {{ $student->gender === 'male' ? 'ወንድ' : 'ሴት' }}</p>
                <p><span class="font-bold text-gray-500">ዓ.ም:</span> 2016 ዓ.ም</p>
            </div>

            <!-- QR Code -->
            <div class="flex-shrink-0">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" class="w-16 h-16 border p-0.5 rounded">
            </div>
        </div>

        <!-- ግርጌ (Footer) -->
        <div class="border-t border-emerald-600 pt-1 flex justify-between items-center text-[7px] text-gray-500">
            <span>ይህ ካርድ የትምህርት ቤቱ ንብረት ነው</span>
            <span class="font-bold text-emerald-900">የአስተዳዳሪ ፊርማ: ________________</span>
        </div>
    </div>

</body>
</html>
