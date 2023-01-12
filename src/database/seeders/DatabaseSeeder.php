<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\FollowUser;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()
            ->has(
                Book::factory()
                    ->has(Review::factory()->count(10))
                    ->count(10)
            )->count(10)
            ->create();

        FollowUser::factory()->create(
            [
                'user_id' => $users[1]?->id,
                'follow_user_id' => $users[0]?->id,
            ]
        );
        FollowUser::factory()->create(
            [
                'user_id' => $users[2]?->id,
                'follow_user_id' => $users[0]?->id,
            ]
        );
    }
}
