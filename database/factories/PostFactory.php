<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title' => fake()->text(50),
            'description' => fake()->text(2000),
            'image' => fake()->imageUrl(640, 480, 'animals', true),
            'user_id' => rand(1, 100),
            'published_at' => Carbon::today()->subDays(rand(0, 365))
        ];
    }
}
