<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::whereNot('id', auth()->id())->get();
        $follwedUsersIds = SubscriberFollowing::where('subscriber_id', auth()->user()->id)->get('following_id')->pluck('following_id')->toArray();
        foreach($users as $user){
            if(in_array($user->id, $follwedUsersIds)){
                $user->is_followed = true;
            }
        }
        return UserResource::collection($users);
    }

    public function posts(User $user){
        return PostResource::collection( $user->posts);
    }

    public function toggleFollowing(User $user){
        $res = auth()->user()->followedUsers()->toggle($user->id);
        $data['is_followed'] = count($res['attached']) > 0;
        return $data;
    }

    public function feed(){
        $followedIds = auth()->user()->followedUsers->pluck('id')->toArray();
        $likedPostsIds = LikedPost::where('user_id', auth()->user()->id)->get('post_id')->pluck('post_id')->toArray();
        $posts = Post::whereIn('user_id', $followedIds)->whereNotIn('id', $likedPostsIds)->get();

        return PostResource::collection($posts);
    }
}
