<?php

namespace Database\Factories;

use App\Models\User;
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
        $users = User::get('id');
        return [
            'title' => fake()->text(50),
            'description' => fake()->text(2000),
            'image' => 'https://picsum.photos/600',
            'user_id' => $users->random(),
            'published_at' => Carbon::today()->subDays(rand(0, 365))
        ];
    }
}
