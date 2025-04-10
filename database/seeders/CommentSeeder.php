<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\UserList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Comment::factory()->count(3)->create([
                'user_id' => $i,
            ])->each(function ($comment) {
                for ($i = 1; $i <= 3; $i++) {
                    Comment::factory()->count(1)->create([
                        'user_id' => User::query()->inRandomOrder()->limit(1)->first()->id,
                        'user_list_id' => $comment->userList->id,
                        'parent_comment_id' => $comment->id,
                    ]);
                }
            });
        }
    }
}
