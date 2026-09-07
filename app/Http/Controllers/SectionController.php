<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use App\Models\Stream;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with(['classes', 'stream'])->get();
        $classes = Classes::orderBy('priority', 'asc')->get();
        $streams = Stream::all();
        return view('admin.sections.index', compact('sections', 'classes', 'streams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|string|max:10', // A, B, C...
            'class_id' => 'required|exists:classes,id',
            'capacity' => 'required|integer|min:1',
        ]);

        Section::create($request->all());

        return redirect()->back()->with('success', 'ሴክሽኑ በተሳካ ሁኔታ ተፈጥሯል!');
    }

    // ተማሪዎችን በክፍሉ የመያዝ አቅም መሰረት በራስ-ሰር የመመደብ ስራ (Auto-Sectioning Engine)
    public function autoAssignStudents(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        $sections = Section::where('class_id', $request->class_id)->get();
        $unassignedStudents = Student::where('class_id', $request->class_id)
            ->whereNull('section_id')
            ->get();

        if ($sections->isEmpty()) {
            return redirect()->back()->with('error', 'ለዚህ ክፍል የተዘጋጀ ሴክሽን የለም! እባክዎ መጀመሪያ ሴክሽን ይፍጠሩ።');
        }

        if ($unassignedStudents->isEmpty()) {
            return redirect()->back()->with('error', 'ያልተመደበ ተማሪ አልተገኘም!');
        }

        $sectionIndex = 0;
        $totalSections = $sections->count();

        foreach ($unassignedStudents as $student) {
            $currentSection = $sections[$sectionIndex];

            // ተማሪውን መመደብ
            $student->update(['section_id' => $currentSection->id]);

            // ወደ ቀጣዩ ሴክሽን ማዞር (እኩል እንዲከፋፈሉ)
            $sectionIndex = ($sectionIndex + 1) % $totalSections;
        }

        return redirect()->back()->with('success', 'ተማሪዎች ወደ ሴክሽኖች በእኩልነት በራስ-ሰር ተመድበዋል!');
    }
}
