<?php

namespace App\Http\Controllers;

use App\Models\CommunicationBook;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicationBookController extends Controller
{
    // የተማሪን የግንኙነት ደብተር ማየት
    public function index($student_id)
    {
        $student = Student::findOrFail($student_id);
        $entries = CommunicationBook::with('teacher.employee')
            ->where('student_id', $student_id)
            ->latest()
            ->paginate(15);

        return view('communication.index', compact('student', 'entries'));
    }

    // መምህሩ አዲስ ማስታወሻ ወይም የቤት ስራ ሲጽፍ
    public function store(Request $request, $student_id)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'message' => 'required|string',
            'type' => 'required|in:homework,conduct,notice,appreciation',
            'date' => 'required|string',
        ]);

        $teacher = Teacher::where('employee_id', optional(Auth::user()->employee)->id)->first();
        $teacherId = $teacher ? $teacher->id : 1; // Fallback

        CommunicationBook::create([
            'student_id' => $student_id,
            'teacher_id' => $teacherId,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'ማስታወሻው በተሳካ ሁኔታ ወደ ግንኙነት ደብተሩ ተልኳል!');
    }

    // ወላጁ ማየቱን ሲያረጋግጥ (Acknowledge) እና ምላሽ ሲሰጥ
    public function acknowledge(Request $request, $id)
    {
        $entry = CommunicationBook::findOrFail($id);

        $entry->update([
            'is_acknowledged' => true,
            'acknowledged_at' => now(),
            'parent_reply' => $request->parent_reply,
        ]);

        return redirect()->back()->with('success', 'ማረጋገጫዎ በተሳካ ሁኔታ ተመዝግቧል!');
    }
}
