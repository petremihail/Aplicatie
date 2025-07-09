<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $i) {
            Post::create([
                'title' => ucfirst($faker->sentence(rand(3, 7))),
                'content' => $faker->paragraphs(rand(3, 7), true),
            ]);
        }
    }
}

