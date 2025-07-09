<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'address' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'previous_jobs' => 'nullable|string',
            'skills' => 'nullable|string',
            'education' => 'nullable|string',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'salary' => $request->salary,
            'previous_jobs' => $request->previous_jobs,
            'skills' => $request->skills,
            'education' => $request->education,
        ]);

        // Attach role
        $user->roles()->attach($request->role_id);

        return redirect()->route('admin.users.index')->with('success', 'Employee created successfully!');
    }

    public function show($id)
    {
        $user = User::with(['roles', 'contracts', 'courses.contents', 'tasks.priority', 'assignedSurveys', 'submissions', 'progress', 'attendances'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'address' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'previous_jobs' => 'nullable|string',
            'skills' => 'nullable|string',
            'education' => 'nullable|string',
        ]);

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'salary' => $request->salary,
            'previous_jobs' => $request->previous_jobs,
            'skills' => $request->skills,
            'education' => $request->education,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update role
        $user->roles()->sync([$request->role_id]);

        return redirect()->route('admin.users.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Detach relationships before deleting
        $user->roles()->detach();
        $user->contracts()->detach();
        $user->courses()->detach();
        $user->tasks()->detach();
        $user->assignedSurveys()->detach();
        
        // Delete related records
        $user->attendances()->delete();
        $user->submissions()->delete();
        $user->progress()->delete();
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Employee deleted successfully!');
    }
}
