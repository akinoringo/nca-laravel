<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\User;
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
        $user = User::factory()->create();
        $community = Community::factory()->create();
        $community->users()->syncWithoutDetaching($community->id);

        return [
            'user_id' => $user->id,
            'community_id' => $community->id,
            'title' => fake()->name(),
            'body' => fake()->text(),
        ];
    }
}
