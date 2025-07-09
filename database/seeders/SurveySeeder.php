<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Survey;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SurveySeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('question_survey')->truncate();
        Question::truncate();
        Survey::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create some users if not present
        if (User::count() < 5) {
            User::factory()->count(5)->create();
        }

        $users = User::pluck('id')->toArray();

        // Create a pool of questions
        $questionPool = collect([
            ['question' => 'How satisfied are you with your job?', 'type' => 'scala'],
            ['question' => 'What motivates you at work?', 'type' => 'liber'],
            ['question' => 'Rate your manager’s communication skills.', 'type' => 'scala'],
            ['question' => 'Describe your biggest challenge at work.', 'type' => 'liber'],
            ['question' => 'Do you feel your work is appreciated?', 'type' => 'scala'],
            ['question' => 'What would you change about your current role?', 'type' => 'liber'],
            ['question' => 'Rate the team collaboration in your department.', 'type' => 'scala'],
            ['question' => 'Share one suggestion for company culture improvement.', 'type' => 'liber'],
            ['question' => 'How often do you receive feedback?', 'type' => 'scala'],
            ['question' => 'What training would benefit you most?', 'type' => 'liber'],
        ]);

        $questionModels = [];
        foreach ($questionPool as $q) {
            $questionModels[] = Question::create($q);
        }

        // Define multiple surveys
        $surveyTitles = [
            'Employee Engagement Survey',
            'Team Collaboration Feedback',
            'Workplace Environment Review',
            'Training Needs Assessment',
            'Manager Feedback Survey',
        ];

        foreach ($surveyTitles as $title) {
            $survey = Survey::create([
                'user_id' => collect($users)->random(),
                'title' => $title,
                'description' => "Help us by completing the '{$title}'. Your feedback is valuable!",
            ]);

            // Attach a random set of 4–7 questions to the survey
            $survey->questions()->attach(
                collect($questionModels)->shuffle()->take(rand(4, 7))->pluck('id')
            );
        }
    }
}