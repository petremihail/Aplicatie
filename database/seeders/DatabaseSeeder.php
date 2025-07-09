<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\User;
use App\Models\Course;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // // User::factory()->create([
        // //     'name' => 'Test User',
        // //     'email' => 'test@example.com',
        // // ]);

        // Contract::factory(3)->create();

        // DB::table('contract_user')->insert([
        //     ['user_id' => 1, 'contract_id' => 1],
        //     ['user_id' => 1, 'contract_id' => 2],
        //     ['user_id' => 2, 'contract_id' => 2],
        // ]);
        
        // DB::table('roles')->insert([
        //         ['name' => 'user'],
        //         ['name' => 'admin'],
        //         ['name' => 'hr']
        //     ]);

        // DB::table('role_user')->insert([
        //     ['role_id' => 1, 'user_id' => 1],
        //     ['role_id' => 1, 'user_id' => 2],
        //     ['role_id' => 1, 'user_id' => 3],
        //     ['role_id' => 1, 'user_id' => 4],
        //     ['role_id' => 1, 'user_id' => 5],
        //     ['role_id' => 1, 'user_id' => 6],
        //     ['role_id' => 1, 'user_id' => 7],
        //     ['role_id' => 1, 'user_id' => 8],
        //     ['role_id' => 1, 'user_id' => 9],
        //     ['role_id' => 1, 'user_id' => 10]
        // ]);

        // Course::factory(10)->create();

        // $this->call([
        //     PrioritySeeder::class, 
        //     TaskSeeder::class,     
        // ]);
        // $this->call(SurveySeeder::class);
        $this->call([
            PostSeeder::class,
        ]);
        
    }   
}
