<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedPost extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table = 'liked_posts';
}
