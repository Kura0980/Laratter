<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Artisan;
use App\User;
use App\Post;

class PostTest extends TestCase
{
    public function setUp() {
        parent::setUp();
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        factory(Post::class, 20)->create();
    }

    /**
     * 記事投稿のテスト
     *
     * @return void
     */
    public function testNewPost()
    {
        //正常系
        $user = factory(User::class)->create();
        $headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];
        $response = $this->actingAs($user)->json('POST', '/api/post', ['sentence' => 'test'], $headers);
        $response->assertStatus(200);

        //異常系(投稿が空だった場合)
        $response = $this->actingAs($user)->json('POST', '/api/post', ['sentence' => ''], $headers);
        $response->assertStatus(400);
    }

    /**
     * ユーザの記事取得のテスト
     * 
     * @return void
     */
    public function testPostShow()
    {
        $post = Post::find(1);
        $user = factory(User::class)->create();
        $headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];
        $response = $this->actingAs($user)->json('GET', '/api/user/'.$post->user_id.'/post', [], $headers);
        $response->assertStatus(200)
        ->assertJson([[
            'id' => true,
            'user_id' => true,
            'sentence' => true
        ]]);
    }

}
