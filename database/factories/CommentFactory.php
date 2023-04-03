<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::get('id');
        $posts = Post::get('id');
        return [
            'body' => fake()->text(),
            'user_id' => $users->random(),
            'commentable_id' => $posts->random(),
            'commentable_type' => 'App\Models\Post'
        ];
    }
}
