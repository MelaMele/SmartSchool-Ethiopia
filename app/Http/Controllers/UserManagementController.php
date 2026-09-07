<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    // አዲስ መምህር ወይም ሰራተኛ መመዝገብ
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'user_id' => 'required|string|unique:users,user_id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_id' => $request->user_id,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'አዲሱ ተጠቃሚ በተሳካ ሁኔታ ተፈጥሯል!');
    }

    // አካውንት ማገድ ወይም ማብራት (Toggle Active/Inactive)
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // ዋናውን አድሚን ራስህን እንዳታግድ መከላከያ
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'የራስዎን ዋና አድሚን አካውንት ማገድ አይችሉም!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusMsg = $user->is_active ? 'አካውንቱ ክፍት ተደርጓል!' : 'አካውንቱ ታግዷል!';
        return redirect()->back()->with('success', $statusMsg);
    }
}
