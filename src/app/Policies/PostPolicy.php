<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

// memo: Policyの仕様でUserモデルは認証済みユーザーを自動で取得して渡される
class PostPolicy
{
    use HandlesAuthorization;

    /**
     * ログインユーザーがポストの登録が可能か
     */
    public function store(User $user, Community $community)
    {
        $userBelongsToCommuity = $community->users()
            ->wherePivot('user_id', $user->id)
            ->exists();

        return $userBelongsToCommuity;
    }
}
