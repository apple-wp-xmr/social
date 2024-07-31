<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\PostInc;

class PostController extends Controller
{
    public function index(){
        $posts = Post::where('user_id', auth()->id())->latest()->get();

        $likeIds = LikedPost::where('user_id', auth()->user()->id)->get('post_id')->pluck('post_id')->toArray();
        foreach($posts as $post){
            if(in_array($post->id, $likeIds)){
                $post->is_liked = true;
            }
        }
        return PostResource::collection($posts);
    }
    public function store(PostRequest $request){
        $data = $request->validated();

        $image_id = $data['image_id'];
        unset($data['image_id']);
        $data['user_id'] = auth()->id();

        try{
            DB::beginTransaction();
            $post = Post::create($data);
            if($image_id){
                $image = PostImage::find($image_id);
                $image->update([
                    'post_id' => $post->id
                ]);
            }
            PostImage::clearStorage();
           
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(
                ['Error is' => $e->getMessage()]
            );
        }

        return new PostResource($post);
    }
    public function toggleLike(Post $post){
        $res = $post->likedUsers()->toggle(auth()->user()->id);
        $data['is_liked'] = count($res['attached']) > 0;
        $post->load('likedUsers');
        $data['likes_count'] = $post->likedUsers->count();
        return $data;
    }
    public function destroy(Post $post){
        if($post->user_id != auth()->id()){
            return response()->json('You anrn\'t the author');
        }
        if($post->image){
            $post->image->delete();
        }
        $post->delete();
        return response()->json("Post $post->id has been deleted!");
    }

}
