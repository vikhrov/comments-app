<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Comment;
use App\Models\Text;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 200; $i++) {
            $parentCommentId = rand(0, 1) ? Comment::inRandomOrder()->value('id') : null;
            $comment = Comment::create([
                'user_name' => $faker->name,
                'email' => $faker->email,
                'home_page' => $faker->url,
                'parent_id' => $parentCommentId,
                'created_at' => $faker->dateTimeBetween('-1 year'),
            ]);

            Text::create([
                'comment_id' => $comment->id,
                'text' => $faker->paragraph,
            ]);

        }
    }
}
