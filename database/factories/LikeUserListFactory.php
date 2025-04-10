<?php

namespace Database\Factories;

use App\Models\UserList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LikeUserListFactory>
 */
class LikeUserListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_list_id' => UserList::query()->inRandomOrder()->limit(1)->first()->id
        ];
    }
}
