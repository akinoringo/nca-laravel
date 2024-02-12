<?php

namespace App\UseCases\Post;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class StoreAction
{
    public function __invoke(User $user, Community $community, Post $post): Post
    {
        $userPostsCountToday = $user->posts()
          ->where('community_id', $community->id)
          ->where('created_at', '>=', Carbon::createMidnightDate())
          ->count();

        if ($userPostsCountToday >= 2) {
          throw new PostLimitExceededException('本日の投稿可能な回数を超えました。');
        }

        $post->user()->associate($user);
        $post->community()->associate($community);
        $post->save();

        return $post;
    }
}
