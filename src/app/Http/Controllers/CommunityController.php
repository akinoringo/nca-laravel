<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;

class CommunityController extends Controller
{

    /**
     * コミュニティを作成するメソッド
     */
    public function store(Request $request)
    {
        $communityName = $request->name;
        $community = Community::create(['name' => $communityName]);
        return response()->json([
            'id' => $community->id,
            'name' =>  $community->name,
        ]);
    }

    /**
     * ユーザーをコミュニティに所属させるメソッド
     */
    public function join(Request $request, Community $community)
    {
        $userId = $request->userId;

        $user = User::findOrFail($userId);
        $user->communities()->syncWithoutDetaching([$community->id]);

        return response()->json(['message' => 'コミュニティに所属しました。']);
    }
}
