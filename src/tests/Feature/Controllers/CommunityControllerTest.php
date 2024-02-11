<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommunityControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * コミュニティ作成テスト
     * 正常系
     */
    public function test_store_success(): void
    {
        $response = $this->postJson('/api/communities', ['name' => 'テストコミュニティ']);
        $response->assertStatus(200)
            ->assertJson(['message' => 'コミュニティを作成しました']);
    }
}
