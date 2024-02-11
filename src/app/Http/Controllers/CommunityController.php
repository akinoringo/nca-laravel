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
        Community::create(['name' => $communityName]);
        return response()->json(['コミュニティを作成しました']);
    }
}
