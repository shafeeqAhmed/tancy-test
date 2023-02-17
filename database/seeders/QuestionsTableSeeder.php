<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('quiz_questions')->insert([
            [
                'uuid' => Str::uuid(),
                'title' => 'Who is the President of the United States?',
                'description' => '',
                'reply' => '',
                'is_mandatory' => 1,
                'quiz_id' => 1,
                'created_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'title' => 'On average how far away is the moon from the earth in miles?',
                'description' => '',
                'reply' => '',
                'is_mandatory' => 0,
                'quiz_id' => 2,
                'created_at' => now(),
            ]

        ]);
    }
}
