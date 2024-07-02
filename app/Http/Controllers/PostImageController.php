<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostImage\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
    public function store(){
        return '222';
    }
}
