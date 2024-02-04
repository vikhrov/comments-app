<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i<40; $i++) {
            DB::table('comments')->insert([
                'user_name' => fake()->name(),
                'email' => fake()->email(),
                'parent_id' => fake()->randomElement([null,3,2,4,5]),
                'created_at' => fake()->date(),
            ]);
        }
    }
}
