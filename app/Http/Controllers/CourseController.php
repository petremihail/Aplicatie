<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Display all courses with pagination and optional category filtering
    public function indexCourses(Request $request)
    {
        $query = Course::query();
        
        // Apply category filter if provided
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        
        // Apply sorting
        $query->orderBy('name');
        
        // Get paginated results (4 courses per page as in your original code)
        $courses = $query->paginate(4);
        
        $user = auth()->user(); // Get logged-in user

        return view('courses.index', compact('courses', 'user'));
    }

    // Assign the course to the user
    public function takeCourse($courseId)
    {
        $user = Auth::user();

        // Attach only if not already attached
        if (!$user->courses->contains($courseId)) {
            $user->courses()->attach($courseId);
        }

        return redirect()->back()->with('success', 'Course assigned!');
    }

    // View a course (user must be enrolled)
    public function viewCourse($id)
    {   
        $course = Course::with('users')->findOrFail($id);
        $user = auth()->user();

        // Check if user is allowed to view the course (they must be enrolled)
        if (!$user->courses->contains($course->id)) {
            return redirect()->back()->with('error', 'You are not enrolled in this course.');
        }

        return view('courses.view', compact('course'));
    }

    // Mark course content as completed by the user
    public function markCompleted($courseId, $contentId)
    {
        $user = auth()->user();

        // Get or create progress for the user and course
        $progress = CourseUserProgress::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $courseId,
        ]);

        // Decode completed content IDs (if any)
        $completed = $progress->completed_content_ids ? json_decode($progress->completed_content_ids) : [];

        // Add the content ID if not already completed
        if (!in_array($contentId, $completed)) {
            $completed[] = $contentId;
            $progress->completed_content_ids = json_encode($completed);
            $progress->save();
        }

        return back()->with('success', 'Marked as completed.');
    }

    // Show the details of a single course
    public function show($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('courses.show', ['course' => $course]);
    }
}