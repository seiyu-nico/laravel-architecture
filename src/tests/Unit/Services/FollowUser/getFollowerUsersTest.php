<?php

namespace Tests\Unit\Services\FollowUser;

use App\Models\FollowUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class getFollowerUsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function test_all()
    {
        $users = User::factory(4)->create();
        $follow_users[] = FollowUser::factory()->create([
            'user_id' => $users[1]->id,
            'follow_user_id' => $users[0]->id,
        ]);
        $follow_users[] = FollowUser::factory()->create([
            'user_id' => $users[2]->id,
            'follow_user_id' => $users[0]->id,
            'deleted_at' => '2022-01-01 00:00:00',
        ]);
        $follow_users[] = FollowUser::factory()->create([
            'user_id' => $users[3]->id,
            'follow_user_id' => $users[0]->id,
        ]);

        $service = app()->make(\App\Services\FollowUserService::class);
        $follow_users = $service->getFollowerUsers(1);
        $this->assertEquals(2, $follow_users->count());

        $this->assertEquals(2, $follow_users[0]['user_id']);
        $this->assertEquals(1, $follow_users[0]['follow_user_id']);

        $this->assertEquals(4, $follow_users[1]['user_id']);
        $this->assertEquals(1, $follow_users[1]['follow_user_id']);
    }
}
