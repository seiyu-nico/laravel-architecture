<?php

namespace Tests\Unit\Services\Book;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function test_create()
    {
        User::factory()->create();
        $book = [
            'user_id' => 1,
            'title' => '本1',
            'content' => '本文1',
        ];

        $service = app()->make(\App\Services\BookService::class);
        $create = $service->create($book);
        $this->assertEquals(1, $create->user_id);
        $this->assertEquals('本1', $create->title);
        $this->assertEquals('本文1', $create->content);
    }
}
