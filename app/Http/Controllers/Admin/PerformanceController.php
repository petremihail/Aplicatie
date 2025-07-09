<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Course;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        // Get all employees (excluding admin users for performance metrics)
        $employees = User::with(['roles', 'tasks', 'courses', 'progress', 'assignedSurveys', 'submissions'])
            // ->whereHas('roles', function($query) {
            //     $query->where('name', '!=', 'admin');
            // })
            ->paginate(10);
        
        $totalEmployees = $employees->total();
        
        // Calculate performance metrics for each employee
        $employeeNames = [];
        $taskCompletionData = [];
        $courseProgressData = [];
        $surveyParticipationData = [];
        $overallScoreData = [];
        
        $totalTaskCompletion = 0;
        $totalCourseProgress = 0;
        $totalSurveyParticipation = 0;
        
        foreach ($employees as $employee) {
            // Task completion rate
            $totalTasks = $employee->tasks->count();
            $completedTasks = $employee->tasks->filter(function($task) {
                return $task->pivot->completed_at !== null;
            })->count();
            
            $taskCompletion = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
            $employee->taskCompletion = $taskCompletion;
            $totalTaskCompletion += $taskCompletion;
            
            // Course progress
            $totalCourseContents = 0;
            $completedCourseContents = 0;
            
            foreach ($employee->courses as $course) {
                $courseContents = $course->contents->count();
                $totalCourseContents += $courseContents;
                
                $progress = $employee->progress->where('course_id', $course->id)->first();
                if ($progress && $courseContents > 0) {
                    $completed = json_decode($progress->completed_content_ids, true) ?: [];
                    $completedCourseContents += count($completed);
                }
            }
            
            $courseProgress = $totalCourseContents > 0 ? ($completedCourseContents / $totalCourseContents) * 100 : 0;
            $employee->courseProgress = $courseProgress;
            $totalCourseProgress += $courseProgress;
            
            // Survey participation
            $assignedSurveys = $employee->assignedSurveys->count();
            $completedSurveys = $employee->submissions->count();
            
            $surveyParticipation = $assignedSurveys > 0 ? ($completedSurveys / $assignedSurveys) * 100 : 0;
            $employee->surveyParticipation = $surveyParticipation;
            $totalSurveyParticipation += $surveyParticipation;
            
            // Overall score (weighted average)
            $overallScore = ($taskCompletion * 0.4) + ($courseProgress * 0.4) + ($surveyParticipation * 0.2);
            $employee->overallScore = $overallScore;
            
            // Add to chart data
            $employeeNames[] = $employee->first_name . ' ' . $employee->last_name;
            $taskCompletionData[] = round($taskCompletion, 1);
            $courseProgressData[] = round($courseProgress, 1);
            $surveyParticipationData[] = round($surveyParticipation, 1);
            $overallScoreData[] = round($overallScore, 1);
        }
        
        // Calculate averages
        $avgTaskCompletion = $totalEmployees > 0 ? $totalTaskCompletion / $totalEmployees : 0;
        $avgCourseProgress = $totalEmployees > 0 ? $totalCourseProgress / $totalEmployees : 0;
        $surveyParticipationRate = $totalEmployees > 0 ? $totalSurveyParticipation / $totalEmployees : 0;
        
        // Get top performers
        $topPerformers = $employees->sortByDesc('overallScore')->take(5);
        $topPerformerNames = $topPerformers->map(function($employee) {
            return $employee->first_name . ' ' . $employee->last_name;
        })->toArray();
        
        $topPerformerScores = $topPerformers->map(function($employee) {
            return round($employee->overallScore, 1);
        })->toArray();
        
        // Chart colors
        $chartColors = [
            'rgba(78, 115, 223, 0.8)',
            'rgba(28, 200, 138, 0.8)',
            'rgba(246, 194, 62, 0.8)',
            'rgba(231, 74, 59, 0.8)',
            'rgba(54, 185, 204, 0.8)'
        ];
        
        return view('admin.performance.index', compact(
            'employees',
            'totalEmployees',
            'avgTaskCompletion',
            'avgCourseProgress',
            'surveyParticipationRate',
            'employeeNames',
            'taskCompletionData',
            'courseProgressData',
            'surveyParticipationData',
            'overallScoreData',
            'topPerformers',
            'topPerformerNames',
            'topPerformerScores',
            'chartColors'
        ));
    }
}
