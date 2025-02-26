<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\UserList;
use App\Models\UserListsItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<30; $i++) {
            UserList::factory()->count(1)->create([
                'user_id' =>  User::query()->inRandomOrder()->limit(1)->first()->id,
                'category_id' =>  Category::query()->inRandomOrder()->limit(1)->first()->id
            ])->each(function ($userlist) {
                UserListsItem::factory()->count(8)->create([
                    'user_list_id' => $userlist->id
                ]);
            });
        }
    }
}
