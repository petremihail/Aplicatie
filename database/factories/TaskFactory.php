<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Priority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'priority_id' => $this->faker->numberBetween(1, 3), // fallback if needed
            'points' => rand(1, 10),
        ];
    }
}
