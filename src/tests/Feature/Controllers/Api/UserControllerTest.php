<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function test_index()
    {
        $users[] = User::factory()->create([
            'name' => 'ほげ',
            'email' => 'hoge@example.com',
        ]);
        $users[] = User::factory()->create([
            'name' => 'ぴよ',
            'email' => 'piyo@example.com',
        ]);
        $users[] = User::factory()->create([
            'name' => 'ほげJP',
            'email' => 'hoge@example.jp',
            'deleted_at' => '2022-01-01 00:00:00',
        ]);
        $users[] = User::factory()->create([
            'name' => 'ぴよJP',
            'email' => 'piyo@example.jp',
        ]);
        $res = $this->get(route('api.users'));

        $body = $res->json();
        $res->assertStatus(200);

        $this->assertEquals(3, count($body));
        $this->assertEquals('ほげ', $body[0]['name']);
        $this->assertEquals('hoge@example.com', $body[0]['email']);
        $this->assertEquals('ぴよ', $body[1]['name']);
        $this->assertEquals('piyo@example.com', $body[1]['email']);
        $this->assertEquals('ぴよJP', $body[2]['name']);
        $this->assertEquals('piyo@example.jp', $body[2]['email']);
    }
}
