<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quizzes')->insert([
            [
                'uuid' => Str::uuid(),
                'title' => 'Do you ever stay behind at school to go to revision classes?',
                'description' => '',
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'title' => 'Do you ever use Sam Learning or My Maths for online learning?',
                'description' => '',
                'user_id' => 2,
                'created_at' => now(),
            ]

        ]);
    }
}
