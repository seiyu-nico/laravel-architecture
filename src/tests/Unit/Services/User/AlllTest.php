<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AllTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function test_all()
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
        $service = app()->make(\App\Services\UserService::class);
        $res = $service->all();

        $this->assertEquals(3, $res->count());
        $this->assertEquals('ほげ', $res[0]->name);
        $this->assertEquals('hoge@example.com', $res[0]->email);
        $this->assertEquals('ぴよ', $res[1]->name);
        $this->assertEquals('piyo@example.com', $res[1]->email);
        $this->assertEquals('ぴよJP', $res[2]->name);
        $this->assertEquals('piyo@example.jp', $res[2]->email);
    }
}
