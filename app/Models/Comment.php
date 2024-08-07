<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table = 'comments';
    protected $width = ['user', 'parent'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function paretn(){
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

}
