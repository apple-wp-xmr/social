<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = false;
    protected $with = ['image'];
    protected $withCount = ['comments',];

    public function image(){
        return $this->hasOne(PostImage::class, 'post_id', 'id')->whereNotNull('post_id');
    }
    public function getDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function likedUsers(){
        return $this->belongsToMany(User::class, 'liked_posts', 'post_id', 'user_id', 'id', 'id');
    }

    public function repost(){
        return $this->belongsTo(Post::class, 'reposted_id', 'id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function reposted_by_posts(){
        return $this->hasMany(Post::class, 'reposted_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
