<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use App\Models\Stream;
use App\Models\Section;
use App\Models\Address;
use App\Models\StudentsParent;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['classes', 'section', 'stream'])->latest()->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = Classes::orderBy('priority', 'asc')->get();
        $streams = Stream::all();
        $sections = Section::all();
        return view('admin.students.create', compact('classes', 'streams', 'sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|in:male,female',
            'birth_date' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // የተማሪ ራስ-ሰር መለያ ቁጥር ማመንጨት (ለምሳሌ፡ STD-2016-0001)
        $student_id = IdGenerator::generate([
            'table' => 'students',
            'field' => 'student_id',
            'length' => 12,
            'prefix' => 'STD-' . date('Y') . '-',
            'reset_on_prefix_change' => true,
        ]);

        // ፎቶ ማስቀመጥ
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students/photos', 'public');
        }

        // አድራሻ መመዝገብ
        $address = Address::create([
            'subcity' => $request->subcity,
            'woreda' => $request->woreda,
            'kebele' => $request->kebele,
            'house_number' => $request->house_number,
            'phone_number' => $request->phone_number,
        ]);

        // ተማሪ መመዝገብ
        $student = Student::create([
            'student_id' => $student_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'photo' => $photoPath,
            'class_id' => $request->class_id,
            'stream_id' => $request->stream_id,
            'section_id' => $request->section_id,
            'address_id' => $address->id,
            'status' => 'active',
        ]);

        // የወላጅ መረጃ መመዝገብ
        if ($request->filled('father_name') || $request->filled('guardian_name')) {
            StudentsParent::create([
                'student_id' => $student->id,
                'father_name' => $request->father_name,
                'father_phone' => $request->father_phone,
                'father_occupation' => $request->father_occupation,
                'mother_name' => $request->mother_name,
                'mother_phone' => $request->mother_phone,
                'guardian_name' => $request->guardian_name,
                'guardian_phone' => $request->guardian_phone,
            ]);
        }

        return redirect()->route('students.index')->with('success', "ተማሪ {$student->full_name} በመታወቂያ ቁጥር {$student_id} በተሳካ ሁኔታ ተመዝግቧል!");
    }

    public function show($id)
    {
        $student = Student::with(['classes', 'section', 'stream', 'address', 'parent', 'markLists.assessmentType', 'markLists.subject', 'attendances'])->findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::with(['address', 'parent'])->findOrFail($id);
        $classes = Classes::orderBy('priority', 'asc')->get();
        $streams = Stream::all();
        $sections = Section::where('class_id', $student->class_id)->get();
        return view('admin.students.edit', compact('student', 'classes', 'streams', 'sections'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'class_id' => 'required|exists:classes,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $student->photo = $request->file('photo')->store('students/photos', 'public');
        }

        $student->update($request->only(['first_name', 'middle_name', 'last_name', 'gender', 'birth_date', 'class_id', 'stream_id', 'section_id', 'status']));

        if ($student->address) {
            $student->address->update($request->only(['subcity', 'woreda', 'kebele', 'house_number', 'phone_number']));
        }

        if ($student->parent) {
            $student->parent->update($request->only(['father_name', 'father_phone', 'mother_name', 'mother_phone', 'guardian_name', 'guardian_phone']));
        }

        return redirect()->route('students.show', $student->id)->with('success', 'የተማሪው መረጃ በተሳካ ሁኔታ ተሻሽሏል!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();

        return redirect()->route('students.index')->with('success', 'የተማሪው መረጃ ተሰርዟል!');
    }
}
