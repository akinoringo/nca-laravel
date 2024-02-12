<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class PostController extends Controller
{
    /**
     * POST communities/{community}/posts
     *
     * というエンドポイントで， {community} に指定された ID でルートモデルバインディング
     */
    public function store(StoreRequest $request, Community $community)
    {
        // 認可
        $user = $request->user();
        $this->authorize('store', [Post::class, $community]);

        // フォーマットバリデーション
        $post = $request->makePost();

        // ドメインバリデーション
        $userPostsCountToday = $user->posts()
            ->where('community_id', $community->id)
            ->where('created_at', '>=', Carbon::createMidnightDate())
            ->count();

        if ($userPostsCountToday >= 2) {
            throw new TooManyRequestsHttpException(null, '本日の投稿可能な回数を超えました。');
        }

        $post->user()->associate($user);
        $post->community()->associate($community);
        $post->save();

        return response()->json(new PostResource($post));
    }
}
