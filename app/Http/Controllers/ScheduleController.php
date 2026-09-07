<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classes::orderBy('priority', 'asc')->get();
        $selectedClassId = $request->class_id ?? optional($classes->first())->id;
        $sections = Section::where('class_id', $selectedClassId)->get();
        $selectedSectionId = $request->section_id ?? optional($sections->first())->id;

        $subjects = Subject::all();
        $teachers = Teacher::with('employee')->get();

        // የክፍሉን መርሃ-ግብር ማምጣት
        $schedules = Schedule::with(['subject', 'teacher.employee'])
            ->where('class_id', $selectedClassId)
            ->where('section_id', $selectedSectionId)
            ->get();

        return view('admin.schedules.index', compact('classes', 'sections', 'subjects', 'teachers', 'schedules', 'selectedClassId', 'selectedSectionId'));
    }

    // አዲስ ክፍለ-ጊዜ መመደብ (ከግጭት መከላከያ ጋር)
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday',
            'period_number' => 'required|integer|between:1,8',
            'academic_year' => 'required|string',
        ]);

        // 1. መምህሩ በዚያ ሰዓት ሌላ ክፍል ማስተማሩን መፈተሽ
        $teacherConflict = Schedule::where('teacher_id', $request->teacher_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('period_number', $request->period_number)
            ->where('academic_year', $request->academic_year)
            ->exists();

        if ($teacherConflict) {
            return redirect()->back()->with('error', 'የመምህር ሰዓት ግጭት! መምህሩ በዚያ ሰዓት በሌላ ክፍል ተመድቧል።');
        }

        // 2. ክፍለ-ጊዜውን መመዝገብ ወይም ማሻሻል
        Schedule::updateOrCreate(
            [
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'day_of_week' => $request->day_of_week,
                'period_number' => $request->period_number,
                'academic_year' => $request->academic_year,
            ],
            [
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
            ]
        );

        return redirect()->back()->with('success', 'ክፍለ-ጊዜው በተሳካ ሁኔታ ተመድቧል!');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'ክፍለ-ጊዜው ተሰርዟል!');
    }
}
