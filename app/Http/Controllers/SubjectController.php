<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:100',
            'subject_code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        Subject::create($request->all());

        return redirect()->back()->with('success', 'የትምህርት አይነቱ በተሳካ ሁኔታ ተመዝግቧል!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_name' => 'required|string|max:100',
            'subject_code' => 'nullable|string|max:20',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($request->all());

        return redirect()->back()->with('success', 'የትምህርት አይነት መረጃ ተሻሽሏል!');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->back()->with('success', 'የትምህርት አይነቱ ተሰርዟል!');
    }
}
