<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentRequest;
use App\Http\Requests\Post\PostRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\RepostResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;

use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    public function index(){
        $posts = Post::where('user_id', auth()->id())->withCount('reposted_by_posts')->latest()->get();

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
    public function repost(Post $post, RepostRequest $repost){
        $data = $repost->validated();
        $data['user_id'] = auth()->id();
        $data['reposted_id'] = $post->id;
        $response = Post::create($data);

        return new RepostResource($response);

    }
    public function getComments(Post $post){
        $comments = $post->comments()->latest()->get();
        return CommentResource::collection($comments);
    }
    public function addComment(Post $post, CommentRequest $comment){
        $data = $comment->validated();
        $data['user_id'] = auth()->id();
        $data['post_id'] = $post->id;

        $comment = Comment::create($data);
        return new CommentResource($comment);
        
    }

}
