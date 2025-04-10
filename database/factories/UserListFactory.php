<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserList>
 */
class UserListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' =>  User::query()->inRandomOrder()->limit(1)->first()->id,
            'category_id' =>  Category::query()->inRandomOrder()->limit(1)->first()->id,
            'header' => fake()->sentence(5),
            'description' => fake()->sentence(10),
        ];
    }
}
