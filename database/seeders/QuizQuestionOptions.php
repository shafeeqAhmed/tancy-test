<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizQuestionOptions extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('quiz_question_options')->insert([
            [
                'uuid' => Str::uuid(),
                'name' => 'Obama',
                'is_correct' => 0,
                'quiz_question_id' => 1,
                'created_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Joe Biden',
                'is_correct' => 1,
                'quiz_question_id' => 1,
                'created_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'name' => '384,400 km ',
                'is_correct' => 0,
                'quiz_question_id' => 2,
                'created_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'name' => '384,430 km',
                'is_correct' => 1,
                'quiz_question_id' => 2,
                'created_at' => now(),
            ]

        ]);
    }
}
