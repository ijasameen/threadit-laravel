<?php

namespace Database\Factories;

use App\PostStatus;
use App\PostVisibility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->paragraph(3);

        return [
            'user_id' => 1,
            'summary' => fake()->sentence(),
            'slug' => Str::slug(substr($title, 0, 40)),
            'body' => fake()->paragraph(5),
            'status' => PostStatus::PUBLISHED,
            'visibility' => PostVisibility::PUBLIC,
            'published_at' => date('Y-m-d H:i:s'),
        ];
    }
}
