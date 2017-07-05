<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag; 
use App\Transformers\TagTransformer;

class TagsController extends ApiController
{

    public function index(){
        $tags = Tag::all();
        return $this->respondWithCollection($tags, new TagTransformer);
    }

    public function show(Tag $tag){
        return $this->respondWithItem($tag, new TagTransformer);
    }
}
