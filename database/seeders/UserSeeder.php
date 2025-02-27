<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\User\Domain\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(1)->create([
            'email' => "admin@gmail.com",
            'user_type' => UserType::ADMIN,
            'password' => Hash::make("12345678"),
        ]);

        User::factory()->count(1)->create([
            'email' => "user@gmail.com",
            'user_type' => UserType::USER,
            'password' => Hash::make("12345678"),
        ]);

        User::factory()->count(8)->create([
            'user_type' => UserType::USER,
        ]);
    }
}
