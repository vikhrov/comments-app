<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i<40; $i++) {
            DB::table('texts')->insert([
                'comment_id' => fake()->randomElement([2,3,4,5,6,7,8,9,10,11]),
                'text' => fake()->text(),
            ]);
        }
    }
}
