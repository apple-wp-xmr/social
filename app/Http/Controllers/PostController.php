<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
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
           
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(
                ['Error is' => $e->getMessage()]
            );
        }

        return new PostResource($post);
    }
}
