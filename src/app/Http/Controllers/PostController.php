<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use App\UseCases\Post\PostLimitExceededException;
use App\UseCases\Post\StoreAction;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class PostController extends Controller
{
    /**
     * POST communities/{community}/posts
     *
     * というエンドポイントで， {community} に指定された ID でルートモデルバインディング
     */
    public function store(StoreRequest $request, Community $community, StoreAction $action)
    {
        // 認可
        $user = $request->user();
        $this->authorize('store', [Post::class, $community]);

        // フォーマットバリデーション
        $post = $request->makePost();

        try {
            // ドメインバリデーションを呼び出す
            return response()->json(new PostResource($action($user, $community, $post)));
        } catch (PostLimitExceededException $e) {
            throw new TooManyRequestsHttpException(null, $e->getMessage(), $e);
        }
    }
}
