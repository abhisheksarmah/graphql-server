<?php

use App\Comment;
use App\Post;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::truncate();
        Comment::unguard();

        $faker = Factory::create();

        Post::all()->each(function ($post) use ($faker) {
            foreach (range(1, 10) as $i) {
                Comment::create([
                    'post_id' => $post->id,
                    'comment' => $faker->sentence(20)
                ]);
            }
        });
    }
}
