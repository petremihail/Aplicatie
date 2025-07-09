<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Priority;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $query = Task::with(['users', 'priority']);

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'completed') {
                $query->whereHas('users', function ($q) {
                    $q->whereNotNull('task_user.completed_at');
                });
            } elseif ($request->status === 'pending') {
                $query->whereHas('users', function ($q) {
                    $q->whereNull('task_user.completed_at');
                });
            }
        }

        // Filter by priority
        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        $tasks = $query->paginate(10);
        $priorities = Priority::all();

        return view('admin.tasks.index', compact('tasks', 'priorities'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $priorities = Priority::all();
        return view('admin.tasks.create', compact('priorities'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'priority_id' => 'required|exists:priorities,id',
            'points' => 'nullable|integer',
        ]);

        Task::create($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $task->load(['users', 'priority']);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $priorities = Priority::all();
        return view('admin.tasks.edit', compact('task', 'priorities'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'priority_id' => 'required|exists:priorities,id',
            'points' => 'nullable|integer',
        ]);

        $task->update($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Show form to assign users to the task.
     */
    public function assignForm(Task $task)
    {
        $users = User::all();
        $assignedUsers = $task->users->pluck('id')->toArray();
        
        return view('admin.tasks.assign', compact('task', 'users', 'assignedUsers'));
    }

    /**
     * Assign users to the task.
     */
    public function assignUsers(Request $request, Task $task)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task->users()->sync($validated['user_ids']);

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Users assigned to task successfully.');
    }
}
