<?php

namespace Tests\Unit\UseCase\Book;

use App\Models\Book;
use App\Models\FollowUser;
use App\Models\User;
use App\Notifications\Book\ReleaseNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Notification;
use Tests\TestCase;

class CreateAndFollowerNotificationUseCaseTest extends TestCase
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
        $book = [
            'user_id' => 1,
            'title' => '本1',
            'content' => '本文1',
        ];

        Notification::fake();

        $use_case = app()->make(\App\UseCase\Book\CreateAndFollowerNotificationUseCase::class);
        /** @var Book $book */
        $book = $use_case(1, $book);
        $this->assertEquals(1, $book->user_id);
        $this->assertEquals('本1', $book->title);
        $this->assertEquals('本文1', $book->content);

        // メールが2個送信されたことをテスト
        Notification::assertSentTimes(ReleaseNotification::class, 2);
    }
}
