<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function assignTaskToUser($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->users()->attach($userId); // or syncWithoutDetaching([$userId]) to avoid duplicates
        return redirect()->back()->with('success', 'Task assigned successfully.');
    }
    // public function userTasks()
    // {
    //     $user = auth()->user();
    //     $tasks = $user->tasks()->with('priority')->paginate(2);

    //     return view('tasks.my', compact('tasks'));
    // }
    public function userTasks(Request $request)
    {
        $user = auth()->user();

        // Start building the query

        $tasksQuery = $user->tasks()->with('priority');
        $tasksNo = $user->tasks();

        // Filter tasks based on completion status
        if ($request->status == 'completed') {
            $tasksQuery = $tasksQuery->whereNotNull('task_user.completed_at');
        } elseif ($request->status == 'pending') {
            $tasksQuery = $tasksQuery->whereNull('task_user.completed_at');
        }

        // Filter tasks based on priority
        if ($request->priority) {
            $tasksQuery = $tasksQuery->where('priority_id', $request->priority);
        }

        // Paginate the results
        $tasks = $tasksQuery->paginate(2);

        // Count completed and total tasks (without pagination)
        $totalTasksCount = $tasksNo->count();
        $completedTasksCount = $tasksNo->whereNotNull('task_user.completed_at')->count();
        $completedTasksPercentage = ($totalTasksCount > 0) ? ($completedTasksCount / $totalTasksCount) * 100 : 0;

        return view('tasks.my', compact('tasks', 'completedTasksCount', 'totalTasksCount', 'completedTasksPercentage'));
    }



    public function complete(Task $task)
    {
        $user = auth()->user();

        if ($user->tasks->contains($task->id)) {
            $user->tasks()->updateExistingPivot($task->id, [
                'completed_at' => now()
            ]);
        }

        return back()->with('success', 'Task marked as completed.');
    }
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'priority_id' => 'required|exists:priorities,id', // Adjust according to your priorities table
        ]);

        // Create the new task
        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'priority_id' => $validated['priority_id'],
            // Add other columns if needed
        ]);

        // Redirect or return a response
        return redirect()->route('tasks.userTasks')->with('success', 'Task created successfully!');
    }
}
