<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Support\Facades\Storage;

class CourseContentController extends Controller
{
    // Display the form to add content to a course
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('course_contents.create', compact('course'));
    }

    // Store the uploaded content
    // public function store(Request $request, $courseId)
    // {
    //     // Validate incoming request
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'type' => 'required|string|in:pdf,video',
    //         'file' => 'required|file|mimes:pdf,mp4|max:20480', // Adjust for file size and types
    //     ]);

    //     // Store file and get its path
    //     $filePath = $request->file('file')->store('course_files', 'public');

    //     // Create course content entry
    //     CourseContent::create([
    //         'course_id' => $courseId,  // Assign the course ID to the content
    //         'title' => $request->title,
    //         'type' => $request->type,
    //         'file_path' => $filePath,  // Store the file path in the database
    //     ]);

    //     // Redirect back to the course page with success message
    //     return redirect()->route('courses.show', $courseId)
    //                      ->with('success', 'Content uploaded successfully!');
    // }
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:pdf,video',
            'file' => 'required|file|max:102400', // 100MB
        ]);

        $path = $request->file('file')->store('course_contents', 'public');

        CourseContent::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        return redirect()->to("admin/courses/{$courseId}")
            ->with('success', 'Course content added successfully.');
    }

    // Add the destroy method to the CourseContentController class
    public function destroy(CourseContent $content)
{
    // Get the course ID before deleting the content
    $courseId = $content->course_id;
    $contentId = $content->id;
    
    // Delete the file from storage
    if (Storage::disk('public')->exists($content->file_path)) {
        Storage::disk('public')->delete($content->file_path);
    }
    
    // Update user progress records to remove this content ID
    $progressRecords = \App\Models\CourseUserProgress::where('course_id', $courseId)->get();
    
    foreach ($progressRecords as $progress) {
        $completed = json_decode($progress->completed_content_ids, true) ?: [];
        
        // Remove the deleted content ID if it exists in the completed array
        if (in_array($contentId, $completed)) {
            $completed = array_diff($completed, [$contentId]);
            $progress->completed_content_ids = json_encode(array_values($completed));
            $progress->save();
        }
    }
    
    // Delete the content record
    $content->delete();
    
    return redirect()->route('admin.courses.show', $courseId)
        ->with('success', 'Content deleted successfully.');
}
}
