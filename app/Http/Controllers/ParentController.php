<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentsParent;
use App\Models\StudentPayment;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // ከወላጁ ጋር የተሳሰሩትን ተማሪዎች መፈለግ
        $parents = StudentsParent::where('user_id', $user->id)
            ->orWhere('father_phone', $user->email)
            ->get();

        $studentIds = $parents->pluck('student_id');
        $students = Student::with(['classes', 'section'])->whereIn('id', $studentIds)->get();

        return view('parent.dashboard', compact('students'));
    }

    // የልጁን ውጤት እና አቴንዳንስ መመልከት
    public function viewStudentDetails($student_id)
    {
        $student = Student::with(['classes', 'section', 'markLists.subject', 'markLists.assessmentType', 'attendances', 'payments'])->findOrFail($student_id);

        return view('parent.student_details', compact('student'));
    }
}
