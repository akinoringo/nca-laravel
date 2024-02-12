<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログインテスト
     * 正常系
     * @group login
     */
    public function test_login_OK(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson('/login', ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(200);
    }
}
