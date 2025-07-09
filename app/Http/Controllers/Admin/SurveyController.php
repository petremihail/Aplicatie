<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Question;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    /**
     * Display a listing of the surveys.
     */
    public function index(Request $request)
    {
        $surveys = Survey::withCount(['questions', 'submissions'])->paginate(10);
        return view('admin.surveys.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new survey.
     */
    public function create()
    {
        return view('admin.surveys.create');
    }

    /**
     * Store a newly created survey in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:text,scala,multiple_choice',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create survey
            $survey = Survey::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'user_id' => auth()->id(),
            ]);

            // Create questions
            foreach ($validated['questions'] as $questionData) {
                $question = Question::create([
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                    'options' => isset($questionData['options']) ? json_encode($questionData['options']) : null,
                ]);

                // Attach question to survey
                $survey->questions()->attach($question->id);
            }

            DB::commit();
            return redirect()->route('admin.surveys.index')
                ->with('success', 'Survey created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create survey: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified survey.
     */
    public function show(Survey $survey)
    {
        $survey->load(['questions', 'assignedUsers']);
        return view('admin.surveys.show', compact('survey'));
    }

    /**
     * Show the form for editing the specified survey.
     */
    public function edit(Survey $survey)
    {
        $survey->load('questions');
        return view('admin.surveys.edit', compact('survey'));
    }

    /**
     * Update the specified survey in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:text,scala,multiple_choice',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update survey
            $survey->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]);

            // Get existing question IDs
            $existingQuestionIds = $survey->questions->pluck('id')->toArray();
            $updatedQuestionIds = [];

            // Update or create questions
            foreach ($validated['questions'] as $questionData) {
                if (isset($questionData['id'])) {
                    // Update existing question
                    $question = Question::find($questionData['id']);
                    $question->update([
                        'question' => $questionData['question'],
                        'type' => $questionData['type'],
                        'options' => isset($questionData['options']) ? json_encode($questionData['options']) : null,
                    ]);
                    $updatedQuestionIds[] = $question->id;
                } else {
                    // Create new question
                    $question = Question::create([
                        'question' => $questionData['question'],
                        'type' => $questionData['type'],
                        'options' => isset($questionData['options']) ? json_encode($questionData['options']) : null,
                    ]);
                    $survey->questions()->attach($question->id);
                    $updatedQuestionIds[] = $question->id;
                }
            }

            // Remove questions that were deleted
            $questionsToDetach = array_diff($existingQuestionIds, $updatedQuestionIds);
            if (!empty($questionsToDetach)) {
                $survey->questions()->detach($questionsToDetach);
            }

            DB::commit();
            return redirect()->route('admin.surveys.index')
                ->with('success', 'Survey updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update survey: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified survey from storage.
     */
    public function destroy(Survey $survey)
    {
        // Delete the survey (this will detach questions due to the pivot table)
        $survey->delete();

        return redirect()->route('admin.surveys.index')
            ->with('success', 'Survey deleted successfully.');
    }

    /**
     * Show form to assign users to the survey.
     */
    public function assignForm(Survey $survey)
    {
        $users = User::all();
        $assignedUsers = $survey->assignedUsers->pluck('id')->toArray();
        
        return view('admin.surveys.assign', compact('survey', 'users', 'assignedUsers'));
    }

    /**
     * Assign users to the survey.
     */
    public function assignUsers(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $survey->assignedUsers()->sync($validated['user_ids']);

        return redirect()->route('admin.surveys.show', $survey)
            ->with('success', 'Users assigned to survey successfully.');
    }

    /**
     * View survey results.
     */
    public function results(Survey $survey)
    {
        $survey->load(['questions', 'submissions.user']);
        
        // Process submissions for display
        $submissions = $survey->submissions;
        $questionStats = [];
        
        foreach ($survey->questions as $question) {
            $answers = [];
            $stats = [
                'total' => 0,
                'average' => null,
                'distribution' => [],
            ];
            
            foreach ($submissions as $submission) {
                $submissionAnswers = json_decode($submission->answers, true);
                if (isset($submissionAnswers[$question->id])) {
                    $answer = $submissionAnswers[$question->id];
                    $answers[] = [
                        'user' => $submission->user->username,
                        'answer' => $answer,
                    ];
                    
                    // Calculate stats for scala questions
                    if ($question->type === 'scala') {
                        $stats['total'] += (int)$answer;
                        if (!isset($stats['distribution'][$answer])) {
                            $stats['distribution'][$answer] = 0;
                        }
                        $stats['distribution'][$answer]++;
                    }
                }
            }
            
            // Calculate average for scala questions
            if ($question->type === 'scala' && count($answers) > 0) {
                $stats['average'] = $stats['total'] / count($answers);
            }
            
            $questionStats[$question->id] = [
                'question' => $question,
                'answers' => $answers,
                'stats' => $stats,
            ];
        }
        
        return view('admin.surveys.results', compact('survey', 'questionStats'));
    }
}
