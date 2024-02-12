<?php

namespace Tests\Feature\Controllers;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommunityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * コミュニティ作成テスト
     * 正常系
     */
    public function test_store_success(): void
    {
        // act
        $response = $this->postJson('/api/communities', ['name' => 'テストコミュニティ']);

        // assert
        $response->assertStatus(200)
            ->assertJson(['name' => 'テストコミュニティ']);
        $this->assertDatabaseHas(Community::class, ['name' => 'テストコミュニティ']);
    }

    /**
     * コミュニティへの参加テスト
     * 正常系
     */
    public function test_join_success(): void
    {
        // arrange
        $user = User::factory()->create();
        $community = Community::factory()->create();

        // act
        $response = $this->postJson("/api/communities/{$community->id}/join", ['userId' => $user->id]);

        // assert
        $response->assertStatus(200)
            ->assertJson(['message' => 'コミュニティに所属しました。']);
        $this->assertDatabaseHas('community_user', [
            'community_id' => $community->id, 'user_id' => $user->id
        ]);
    }
}
