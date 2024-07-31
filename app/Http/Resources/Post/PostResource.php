<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = isset($this->image) ? $this->image->url : null;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image_url' => $image,
            'date' => $this->date,
            'is_liked' => $this->is_liked ?? null,
            'likes_count' => $this->likedUsers->count() ?? null,
            'repost' => new RepostResource($this->repost),
            'comments_count' => $this->comments_count,
        ];
    }
}
