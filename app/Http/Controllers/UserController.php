<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StatRequest;
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
        $posts = $user->posts()->withCount('reposted_by_posts')->latest()->get();
        $likeIds = LikedPost::where('user_id', auth()->user()->id)->get('post_id')->pluck('post_id')->toArray();
        foreach($posts as $post){
            if(in_array($post->id, $likeIds)){
                $post->is_liked = true;
            }
        }
        return PostResource::collection( $posts);
    }

    public function toggleFollowing(User $user){
        $res = auth()->user()->followedUsers()->toggle($user->id);
        $data['is_followed'] = count($res['attached']) > 0;
        return $data;
    }

    public function feed(){
        $followedIds = auth()->user()->followedUsers->pluck('id')->toArray();
        $likedPostsIds = LikedPost::where('user_id', auth()->user()->id)->get('post_id')->pluck('post_id')->toArray();
        $posts = Post::whereIn('user_id', $followedIds)->withCount('reposted_by_posts')->whereNotIn('id', $likedPostsIds)->get();

        return PostResource::collection($posts);
    }
    public function getStats(StatRequest $request){
        $data = $request->validated();
        $userId = isset($data['user_id']) ? $data['user_id'] : auth()->id();

        $result = [];
        $result['subscribers_count'] = SubscriberFollowing::where('following_id', $userId)->count();
        $result['followers_count'] = SubscriberFollowing::where('subscriber_id', $userId)->count();
 
        $postIds = Post::where('user_id', $userId)->get('id')->pluck('id')->toArray();
        $result['likes_count'] = LikedPost::whereIn('user_id', $postIds)->count();
        $result['posts_count'] = count($postIds);

        return response()->json(['data' => $result]);

    }

}
