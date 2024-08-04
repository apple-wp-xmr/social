<?php

use App\Http\Controllers\GetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostImageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/post', [PostController::class, 'store']);
    Route::post('/posts/{post}/toggle_like', [PostController::class, 'toggleLike']);
    Route::post('/post_image', [PostImageController::class, 'store']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    Route::post('/posts/{post}/repost', [PostController::class, 'repost']);
    Route::post('/posts/{post}/add_comment', [PostController::class, 'addComment']);
    Route::get('/posts/{post}/comments', [PostController::class, 'getComments']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/feed', [UserController::class, 'feed']);
    Route::get('/users/{user}/posts', [UserController::class, 'posts']);
    Route::post('/users/{user}/toggle_following', [UserController::class, 'toggleFollowing']);
    Route::post('/users/stats', [UserController::class, 'getStats']);
});

