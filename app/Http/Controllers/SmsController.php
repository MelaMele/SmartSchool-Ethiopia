<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use App\Models\SmsLog;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function index()
    {
        $classes = Classes::orderBy('priority', 'asc')->get();
        $logs = SmsLog::with('student')->latest()->paginate(20);

        return view('admin.sms.index', compact('classes', 'logs'));
    }

    // ለሁሉም ወይም ለተወሰነ ክፍል ወላጆች SMS በጅምላ መላኪያ (Bulk SMS)
    public function sendBulk(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:320',
            'target' => 'required|string', // all, or specific class_id
        ]);

        $studentsQuery = Student::with('parent', 'address')->where('status', 'active');

        if ($request->target !== 'all') {
            $studentsQuery->where('class_id', $request->target);
        }

        $students = $studentsQuery->get();
        $sentCount = 0;

        foreach ($students as $student) {
            $phone = optional($student->parent)->father_phone ?? optional($student->address)->phone_number;
            if ($phone) {
                SmsService::send($phone, $request->message, 'general_notice', $student->id);
                $sentCount++;
            }
        }

        return redirect()->back()->with('success', "መልዕክቱ ለ {$sentCount} ወላጆች በተሳካ ሁኔታ ተልኳል!");
    }
}
