<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\User;
use App\Models\Priority;

class TaskAdminController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('users', 'priority')
            ->when($request->status === 'completed', fn($q) => $q->whereHas('users', fn($q) => $q->whereNotNull('completed_at')))
            ->when($request->status === 'incomplete', fn($q) => $q->whereHas('users', fn($q) => $q->whereNull('completed_at')))
            ->get();

        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $priorities = Priority::all();
        return view('admin.tasks.create', compact('priorities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date',
            'priority_id' => 'required|exists:priorities,id',
            'points' => 'required|integer'
        ]);

        Task::create($request->all());
        return redirect()->route('admin.tasks.index')->with('success', 'Task created.');
    }

    public function assignForm(Task $task)
    {
        $users = User::whereHas('roles', fn($q) => $q->whereIn('name', ['user']))->get();
        return view('admin.tasks.assign', compact('task', 'users'));
    }

    public function assign(Request $request, Task $task)
    {
        $request->validate(['user_ids' => 'required|array']);
        $task->users()->syncWithoutDetaching($request->user_ids);
        return redirect()->route('admin.tasks.index')->with('success', 'Users assigned.');
    }
}