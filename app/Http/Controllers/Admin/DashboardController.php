<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Task;
use App\Models\User;
use App\Models\Course;
use App\Models\Survey;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get counts for dashboard cards
        $recentUsers = User::where('created_at', '>=', now()->subDay())
    ->orderBy('created_at', 'desc')
    ->get();

$recentTasks = Task::where('created_at', '>=', now()->subDay())
    ->orderBy('created_at', 'desc')
    ->get();
        $userCount = User::count();
        $courseCount = Course::count();
        $pendingTaskCount = Task::whereHas('users', function($query) {
            $query->whereNull('task_user.completed_at');
        })->count();
        $surveyCount = Survey::count();

        // Recent activities
        $recentActivities = $this->getRecentActivities();

        // Upcoming deadlines
        $upcomingDeadlines = $this->getUpcomingDeadlines();

        return view('admin.dashboard', compact(
            'userCount',
            'courseCount',
            'pendingTaskCount',
            'surveyCount',
            'recentActivities',
            'upcomingDeadlines',
            'recentUsers',
            'recentTasks'
        ));
    }

    private function getRecentActivities()
    {
        $activities = [];

        // New users
        $newUsers = User::orderBy('created_at', 'desc')->take(3)->get();
        foreach ($newUsers as $user) {
            $activities[] = [
                'title' => 'New Employee: ' . $user->first_name . ' ' . $user->last_name,
                'description' => 'A new employee has been added to the system.',
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'fa-user',
                'color' => 'primary'
            ];
        }

        // Completed tasks
        $completedTasks = Task::whereHas('users', function ($query) {
            $query->whereNotNull('task_user.completed_at');
        })
        ->with(['users' => function ($query) {
            $query->whereNotNull('task_user.completed_at')->withPivot('completed_at');
        }])
        ->orderBy('updated_at', 'desc')
        ->take(3)
        ->get();

        foreach ($completedTasks as $task) {
            $user = $task->users->first(); // deja are withPivot
            if ($user && $user->pivot && $user->pivot->completed_at) {
                $activities[] = [
                    'title' => 'Task Completed: ' . $task->title,
                    'description' => 'Completed by ' . $user->first_name . ' ' . $user->last_name,
                    'time' => Carbon::parse($user->pivot->completed_at)->diffForHumans(),
                    'icon' => 'fa-check-circle',
                    'color' => 'success'
                ];
            }
        }
        

        // New posts
        $newPosts = Post::orderBy('created_at', 'desc')->take(2)->get();
        foreach ($newPosts as $post) {
            $activities[] = [
                'title' => 'New Announcement: ' . $post->title,
                'description' => Str::limit($post->content, 50),
                'time' => $post->created_at->diffForHumans(),
                'icon' => 'fa-bullhorn',
                'color' => 'info'
            ];
        }

        // Sort by most recent
        usort($activities, function($a, $b) {
            return strtotime(Carbon::parse($b['time'])) - strtotime(Carbon::parse($a['time']));
        });

        return array_slice($activities, 0, 5);
    }

    private function getUpcomingDeadlines()
    {
        $deadlines = [];

        // Upcoming task deadlines
        $upcomingTasks = Task::where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->orderBy('due_date')
            ->take(5)
            ->get();

        foreach ($upcomingTasks as $task) {
            $deadlines[] = [
                'title' => 'Task: ' . $task->title,
                'date' => Carbon::parse($task->due_date)->format('M d, Y'),
                'icon' => 'fa-tasks',
                'color' => 'warning'
            ];
        }

        // Add other types of deadlines here if needed

        return $deadlines;
    }
}
