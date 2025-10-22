<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(20)->create();

        Reply::factory(80)->create([
            'user_id' => 1,
            'post_id' => fn () => rand(1, 20),
        ]);
    }
}
