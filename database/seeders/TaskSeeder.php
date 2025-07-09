<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Priority;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Task::factory(20)->create()->each(function ($task) {
            $users = User::inRandomOrder()->take(rand(1, 11))->pluck('id');
            $task->users()->attach($users);
        });
    }
}
