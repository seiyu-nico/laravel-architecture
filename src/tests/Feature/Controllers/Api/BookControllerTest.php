<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Book;
use App\Models\FollowUser;
use App\Models\Review;
use App\Models\User;
use App\Notifications\Book\ReleaseNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Notification;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function test_showUserBooks()
    {
        $user = User::factory()->create([
            'name' => 'ほげ',
            'email' => 'hoge@example.com',
        ]);
        $books[] = Book::factory()->create([
            'user_id' => $user->id,
            'title' => '本1',
            'content' => '本文1',
        ]);
        $books[] = Book::factory()->create([
            'user_id' => $user->id,
            'title' => '本2',
            'content' => '本文2',
        ]);
        // Book1のレビュー
        Review::factory()->create([
            'book_id' => $books[0]->id,
            'score_a' => 1,
            'score_b' => 2,
            'score_c' => 3,
        ]);
        Review::factory()->create([
            'book_id' => $books[0]->id,
            'score_a' => 2,
            'score_b' => 3,
            'score_c' => 4,
        ]);
        Review::factory()->create([
            'book_id' => $books[0]->id,
            'score_a' => 1,
            'score_b' => 3,
            'score_c' => 5,
            'deleted_at' => '2022-01-01 00:00:00',
        ]);
        // Book2のレビュー
        Review::factory()->create([
            'book_id' => $books[1]->id,
            'score_a' => 1,
            'score_b' => 2,
            'score_c' => 3,
        ]);
        Review::factory()->create([
            'book_id' => $books[1]->id,
            'score_a' => 1,
            'score_b' => 2,
            'score_c' => 5,
        ]);

        $res = $this->get(route('api.users.books', $user->id));
        $res->assertStatus(200);
        $body = $res->json();
        $this->assertEquals(2, count($body));
        $this->assertEquals(1, $body[0]['user_id']);
        $this->assertEquals('本1', $body[0]['title']);
        $this->assertEquals('本文1', $body[0]['content']);
        $this->assertEquals(2.5, $body[0]['avg_score']);
        $this->assertEquals(1, $body[1]['user_id']);
        $this->assertEquals('本2', $body[1]['title']);
        $this->assertEquals('本文2', $body[1]['content']);
        $this->assertEquals(2.4, $body[1]['avg_score']);
    }

    /**
     * @return void
     */
    public function test_store()
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
