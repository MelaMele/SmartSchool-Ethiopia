<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Semister;
use App\Models\AssasmentType;
use App\Models\Student;
use App\Models\StudentMarkList;
use Illuminate\Http\Request;

class MarklistController extends Controller
{
    public function index()
    {
        $classes = Classes::orderBy('priority', 'asc')->get();
        $semisters = Semister::all();
        $assessments = AssasmentType::all();
        $subjects = Subject::all();

        return view('admin.marklist.index', compact('classes', 'semisters', 'assessments', 'subjects'));
    }

    // ውጤት መመዝገብ
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'semister_id' => 'required|exists:semisters,id',
            'assasment_type_id' => 'required|exists:assasment_types,id',
            'marks' => 'required|array', // ['student_id' => mark_value]
        ]);

        foreach ($request->marks as $studentId => $mark) {
            if ($mark !== null) {
                StudentMarkList::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'class_id' => $request->class_id,
                        'section_id' => $request->section_id,
                        'subject_id' => $request->subject_id,
                        'semister_id' => $request->semister_id,
                        'assasment_type_id' => $request->assasment_type_id,
                    ],
                    [
                        'mark' => $mark,
                        'load' => 100,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'የተማሪዎች ውጤት በተሳካ ሁኔታ ተመዝግቧል!');
    }

    // የተማሪ ሙሉ የውጤት ካርድ (Report Card)
    public function generateReportCard($student_id, $semister_id)
    {
        $student = Student::with(['classes', 'section', 'stream'])->findOrFail($student_id);
        $semister = Semister::findOrFail($semister_id);

        $marks = StudentMarkList::with(['subject', 'assessmentType'])
            ->where('student_id', $student_id)
            ->where('semister_id', $semister_id)
            ->get()
            ->groupBy('subject_id');

        return view('admin.marklist.report_card', compact('student', 'semister', 'marks'));
    }
}
