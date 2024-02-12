<?php

namespace App\Http\Controllers;

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
    public function store(Request $request, Community $community)
    {
        $userId = $request->userId;
        // 認可
        $userBelongsToCommuity = $community->users()
            ->wherePivot('user_id', $userId)
            ->exists();
        if (!$userBelongsToCommuity) {
            throw new AccessDeniedException('ユーザは指定されたコミュニティに所属していません');
        }

        // フォーマットバリデーション
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:30',
            'body' => 'required|string|max:10000',
        ]);
        $validator->validate();

        // ドメインバリデーション
        $user = User::findOrFail($userId);
        $userPostsCountToday = $user->posts()
            ->where('community_id', $community->id)
            ->where('created_at', '>=', Carbon::createMidnightDate())
            ->count();

        if ($userPostsCountToday >= 2) {
            throw new TooManyRequestsHttpException(null, '本日の投稿可能な回数を超えました。');
        }

        $post = new Post($validator->validated());
        $post->user()->associate($user);
        $post->community()->associate($community);
        $post->save();

        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body
        ]);
    }
}
