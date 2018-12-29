<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();
        \Artisan::call('migrate:refresh');
        \Artisan::call('migrate');
    }

    /**
     * いいね機能のテスト
     *
     * @return void
     */
    public function testLike()
    {
        $user = factory(\App\User::class)->create();
        $post = factory(\App\Post::class)->create();
        $headers = ['Authorization' => 'Bearer ' . \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user)];
        $response = $this->json('POST', '/api/like', ['post_id' => $post->id], $headers);
        $response->assertStatus(201);

        $response = $this->json('DELETE', '/api/like/'. $post->id, [], $headers);
        $response->assertStatus(204);

    }

}
