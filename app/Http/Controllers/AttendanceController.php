<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes = Classes::orderBy('priority', 'asc')->get();
        return view('admin.attendance.index', compact('classes'));
    }

    public function getStudents(Request $request)
    {
        $students = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('status', 'active')
            ->get();

        return response()->json($students);
    }

    // አቴንዳንስ መመዝገብ
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'attendance_date' => 'required|string', // በኢትዮጵያ ቀን አቆጣጠር (2016-01-15)
            'attendance' => 'required|array', // ['student_id' => 'present|absent|late|permission']
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'attendance_date' => $request->attendance_date,
                ],
                [
                    'status' => $status,
                    'remark' => $request->remarks[$studentId] ?? null,
                    'recorded_by' => Auth::id(),
                ]
            );
        }

        return redirect()->back()->with('success', 'የዕለቱ አቴንዳንስ በተሳካ ሁኔታ ተመዝግቧል!');
    }
}
