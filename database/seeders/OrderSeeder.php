<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
                'uuid' => Str::uuid(),
                'name' => 'Garmments',
                'user_id' => 1,
                'amount' => 500,
                'qty' => 4,
                'description' => '',
                'created_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Sports',
                'user_id' => 2,
                'amount' => 900,
                'qty' => 3,
                'description' => '',
                'created_at' => now(),
            ]
        ]);
    }
}
