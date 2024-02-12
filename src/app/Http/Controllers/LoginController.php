<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => ['sometimes', 'required', 'boolean'],
        ]);

        if (Auth::attempt(Arr::only($credentials, ['email', 'password']), (bool) $request->remember)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'ログインしました']);
        }

        return response()->json([
            'message' => 'メールアドレスまたはパスワードが正しくありません。もう一度お試しください。'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
