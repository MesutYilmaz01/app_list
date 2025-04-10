<?php

namespace Database\Seeders;

use App\Models\DislikeComment;
use App\Models\DislikeUserList;
use App\Models\LikeComment;
use App\Models\LikeUserList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeDislikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            LikeComment::factory()->count(3)->create([
                'user_id' => $i
            ]);
            LikeUserList::factory()->count(3)->create([
                'user_id' => $i
            ]);
            DislikeComment::factory()->count(3)->create([
                'user_id' => $i
            ]);
            DislikeUserList::factory()->count(3)->create([
                'user_id' => $i
            ]);
        }
    }
}
