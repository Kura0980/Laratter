<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /**
     * ユーザ認証のテスト
     * 
     * @return void
     */
    public function testAuthenicate()
    {
        //正常系
        $user = factory(User::class)->create();
        $param = [
            'email' => $user->email,
            'password' => 'secret'
        ];
        $response = $this->json('POST', '/api/user', $param);
        $response
        ->assertStatus(200)
        ->assertJson([
            'user' => [
                'name' => true,
                'id' => true,
                'created_at' => true
            ],
            'token' => true
        ]);

        //異常系(認証情報が間違っている場合)
        $param = [
            'email' => $user->email,
            'password' => 'invalid_pass'
        ];
        $response = $this->json('POST', '/api/user', $param);
        $response->assertStatus(401);
        
        //異常系(入力に不備がある場合)
        $pram = [
            'email' => '',
            'password' => ''
        ];
        $response = $this->json('POST', '/api/user', $param);
        $response->assertStatus(400);

    }

    /**
     * ユーザ登録のテスト
     *
     * @return void
     */
    public function testRegister()
    {
        //正常系
        $param = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test&test'
        ];
        $response = $this->json('POST', '/api/user/register', $param);
        $response
        ->assertStatus(201)
        ->assertJson([
            'user' => [
                'name' => true,
                'id' => true,
                'created_at' => true
            ],
            'token' => true
        ]);

        //異常系(登録済のメールアドレスの場合)
        $response = $this->json('POST', '/api/user/register', $param);
        $response->assertStatus(400);

        //異常系(入力値に不備がある場合)
        $inadequacyParam = [
            'name' => '',
            'email' => '',
            'password' => ''
        ];
        $response = $this->json('POST', '/api/user/register', $inadequacyParam);
        $response->assertStatus(400);

    }
}
