<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Postings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create();

            $posts = Post::factory(2)->create();
            
            foreach ($posts as $post) {
                Postings::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}