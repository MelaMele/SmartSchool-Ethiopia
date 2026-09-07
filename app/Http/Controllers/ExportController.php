<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ExportController extends Controller
{
    // ለአንድ ተማሪ መታወቂያ ማመንጨት
    public function generateSingleIdCard($id)
    {
        $student = Student::with(['classes', 'section', 'stream'])->findOrFail($id);

        // ለተማሪው መታወቂያ QR Code ማመንጨት
        $qrData = "ID: {$student->student_id}\nName: {$student->full_name}\nClass: {$student->classes->class_label}";
        $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate($qrData));

        return view('admin.export.single_id', compact('student', 'qrCode'));
    }

    // ለአንድ ሙሉ ክፍል መታወቂያ ማመንጨት
    public function generateClassIdCards($class_id, $section_id)
    {
        $students = Student::with(['classes', 'section'])
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('status', 'active')
            ->get();

        $studentsWithQr = $students->map(function ($student) {
            $qrData = "ID: {$student->student_id}\nName: {$student->full_name}\nClass: {$student->classes->class_label}";
            $student->qrCode = base64_encode(QrCode::format('svg')->size(90)->generate($qrData));
            return $student;
        });

        return view('admin.export.class_ids', compact('studentsWithQr'));
    }
}
