<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>የውጤት ካርድ - {{ $student->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; p: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

    <div class="no-print max-w-3xl mx-auto mb-6 flex justify-between items-center">
        <a href="javascript:history.back()" class="text-sm font-bold text-gray-600">← ተመለስ</a>
        <button onclick="window.print()" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold shadow hover:bg-emerald-700">
            🖨️ የውጤት ካርዱን አትም (Print Report Card)
        </button>
    </div>

    <div class="max-w-3xl mx-auto bg-white border-2 border-slate-800 p-8 shadow-lg rounded-lg">
        <!-- ራስጌ -->
        <div class="text-center border-b-2 border-slate-800 pb-4 mb-6">
            <h1 class="text-2xl font-black text-slate-900 uppercase">SMARTSCHOOL ETHIOPIA</h1>
            <h2 class="text-lg font-bold text-emerald-800">የተማሪ የውጤት መግለጫ ካርድ (STUDENT REPORT CARD)</h2>
            <p class="text-xs text-gray-500 mt-1">የትምህርት ዘመን፦ {{ $semister->academic_year }} | {{ $semister->semister_name }}</p>
        </div>

        <!-- የተማሪ መረጃ -->
        <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded border border-gray-200 text-sm mb-6">
            <div>
                <p><span class="font-bold">የተማሪው ስም:</span> {{ $student->full_name }}</p>
                <p><span class="font-bold">መለያ ቁጥር:</span> {{ $student->student_id }}</p>
            </div>
            <div>
                <p><span class="font-bold">ክፍል እና ሴክሽን:</span> {{ $student->classes->class_label }} - {{ $student->section ? $student->section->section_name : 'A' }}</p>
                <p><span class="font-bold">ጾታ:</span> {{ $student->gender === 'male' ? 'ወንድ' : 'ሴት' }}</p>
            </div>
        </div>

        <!-- የውጤት ሰንጠረዥ -->
        <table class="w-full border-collapse border border-slate-400 text-sm text-center mb-6">
            <thead>
                <tr class="bg-slate-200 font-bold text-xs uppercase">
                    <th class="border border-slate-400 p-2 text-left">የትምህርት አይነት</th>
                    <th class="border border-slate-400 p-2">የፈተና ውጤት ድምር (100%)</th>
                    <th class="border border-slate-400 p-2">ደረጃ (Grade)</th>
                </tr>
            </thead>
            <tbody>
                @php $totalMarks = 0; $count = 0; @endphp
                @foreach($marks as $subjectId => $subjectMarks)
                    @php
                        $subjectTotal = $subjectMarks->sum('mark');
                        $totalMarks += $subjectTotal;
                        $count++;
                        $subjectName = $subjectMarks->first()->subject->subject_name;
                    @endphp
                    <tr>
                        <td class="border border-slate-400 p-2 text-left font-semibold">{{ $subjectName }}</td>
                        <td class="border border-slate-400 p-2 font-mono font-bold">{{ $subjectTotal }}</td>
                        <td class="border border-slate-400 p-2 font-bold">
                            @if($subjectTotal >= 90) A+
                            @elseif($subjectTotal >= 85) A
                            @elseif($subjectTotal >= 80) B+
                            @elseif($subjectTotal >= 70) B
                            @elseif($subjectTotal >= 60) C
                            @elseif($subjectTotal >= 50) D
                            @else F @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-slate-100 font-bold">
                    <td class="border border-slate-400 p-2 text-left">አጠቃላይ ድምር (Total)</td>
                    <td class="border border-slate-400 p-2 font-mono text-emerald-800">{{ $totalMarks }}</td>
                    <td class="border border-slate-400 p-2"></td>
                </tr>
                <tr class="bg-emerald-50 font-bold text-emerald-900">
                    <td class="border border-slate-400 p-2 text-left">አማካይ ውጤት (Average)</td>
                    <td class="border border-slate-400 p-2 font-mono">{{ $count > 0 ? number_format($totalMarks / $count, 2) : 0 }}%</td>
                    <td class="border border-slate-400 p-2"></td>
                </tr>
            </tfoot>
        </table>

        <!-- አስተያየት እና ፊርማ -->
        <div class="grid grid-cols-2 gap-8 pt-8 border-t border-gray-300 text-xs">
            <div>
                <p class="font-bold mb-8">የክፍል ተረካቢ መምህር አስተያየት እና ፊርማ:</p>
                <div class="border-b border-slate-800"></div>
            </div>
            <div>
                <p class="font-bold mb-8">የትምህርት ቤቱ ርዕሰ መምህር ፊርማ እና ማህተም:</p>
                <div class="border-b border-slate-800"></div>
            </div>
        </div>
    </div>

</body>
</html>
