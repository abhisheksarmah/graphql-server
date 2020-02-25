<?php

use App\Post;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();
        Post::unguard();

        $faker = Factory::create();

        User::all()->each(function ($user) use ($faker) {
            foreach (range(1, 5) as $i) {
                Post::create([
                    'user_id' => $user->id,
                    'title' => $faker->sentence,
                    'description' => $faker->sentence(40)
                ]);
            }
        });
    }
}
