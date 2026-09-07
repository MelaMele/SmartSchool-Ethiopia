<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Stream;
use App\Models\Section;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('sections')->orderBy('priority', 'asc')->get();
        $streams = Stream::all();
        return view('admin.classes.index', compact('classes', 'streams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_label' => 'required|string|max:50',
            'priority' => 'required|integer',
        ]);

        Classes::create([
            'class_label' => $request->class_label,
            'priority' => $request->priority,
        ]);

        return redirect()->back()->with('success', 'አዲሱ የክፍል ደረጃ በተሳካ ሁኔታ ተመዝግቧል!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'class_label' => 'required|string|max:50',
            'priority' => 'required|integer',
        ]);

        $class = Classes::findOrFail($id);
        $class->update([
            'class_label' => $request->class_label,
            'priority' => $request->priority,
        ]);

        return redirect()->back()->with('success', 'የክፍል ደረጃ መረጃ ተሻሽሏል!');
    }

    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->back()->with('success', 'ክፍሉ በተሳካ ሁኔታ ተሰርዟል!');
    }
}
