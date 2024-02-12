<?php

namespace Tests\Feature\Controllers;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 投稿作成テスト
     * 正常系
     */
    public function test_store_OK(): void
    {
        // arange
        $user = User::factory()->create();
        $this->actingAs($user);
        $community = Community::factory()->create();
        $user->communities()->syncWithoutDetaching($community->id);

        // act
        $response = $this->postJson("/api/communities/{$community->id}/posts", [
            'title' => 'テストタイトル',
            'body' => 'テストボディ'
        ]);

        // assert
        $response->assertStatus(200)
            ->assertJson([
                'title' => 'テストタイトル',
                'body' => 'テストボディ'
            ]);
    }

    /**
     * 投稿作成テスト
     * 異常系
     */
    public function test_store_NG(): void
    {
        // arange
        $user = User::factory()->create();
        $this->actingAs($user);
        $community = Community::factory()->create();
        $user->communities()->syncWithoutDetaching($community->id);
        Post::factory(2)->create(['user_id' => $user->id, 'community_id' => $community->id]);

        // act
        $response = $this->postJson("/api/communities/{$community->id}/posts", [
            'title' => 'テストタイトル',
            'body' => 'テストボディ'
        ]);

        // assert
        $response->assertStatus(429); // 投稿件数エラー
    }
}
