<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table = 'post_images';

    public function getUrlAttribute(){
        return url('/storage/' . $this->path);
    }

    public static function clearStorage(){
        $images = PostImage::where('user_id', auth()->id())->whereNotNull('post_id');
    }
}
