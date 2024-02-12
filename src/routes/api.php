<?php

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/communities')->group(function () {
        Route::post('/{community}/join', [CommunityController::class, 'join']);
        Route::post('/', [CommunityController::class, 'store']);
    });
});

Route::prefix('/communities')->group(function () {
    Route::post('/{community}/posts', [PostController::class, 'store']);
});
