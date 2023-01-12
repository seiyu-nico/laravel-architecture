<?php

namespace Tests\Unit\Services\Book;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FindByUserIdTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function test_all()
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

        $service = app()->make(\App\Services\BookService::class);
        $res = $service->findByUserId(1);
        $this->assertEquals(2, $res->count());
        $this->assertEquals(1, $res[0]['user_id']);
        $this->assertEquals('本1', $res[0]['title']);
        $this->assertEquals('本文1', $res[0]['content']);
        $this->assertEquals(2.5, $res[0]['avg_score']);
        $this->assertEquals(1, $res[1]['user_id']);
        $this->assertEquals('本2', $res[1]['title']);
        $this->assertEquals('本文2', $res[1]['content']);
        $this->assertEquals(2.4, $res[1]['avg_score']);
    }
}
