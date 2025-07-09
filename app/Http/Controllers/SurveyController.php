<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function indexSurvey()
    {
        $user = auth()->user();

        // Load assigned surveys, and count submissions by the current user
        $surveys = $user->assignedSurveys()
            ->with('user')
            ->withCount(['submissions as user_submitted' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->latest()
            ->paginate(2);

        return view('surveys.index', compact('surveys'));
    }

    public function show(Survey $survey)
    {
        $survey->load('questions');
        return view('surveys.show', compact('survey'));
    }

    public function submit(Request $request, Survey $survey)
    {
        $data = $request->validate([
            'answers' => 'required|array',
        ]);

        Submission::create([
            'user_id' => Auth::id(),
            'survey_id' => $survey->id,
            'submitted_at' => now(),
            'answers' => json_encode($data['answers']),
        ]);
        if (Submission::where('survey_id', $survey->id)->where('user_id', Auth::id())->exists()) {
            return redirect()->route('surveys.indexSurvey')->with('error', 'You have already submitted this survey.');
        }
        return redirect()->route('surveys.indexSurvey')->with('success', 'Thank you for your submission!');
    }
}
