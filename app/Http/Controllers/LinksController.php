<?php
namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use App\Transformers\LinkTransformer;

class LinksController extends ApiController
{
    protected function setMiddlewareMethods(){
        $this->middleware('auth:api')->except('index', 'show', 'sticky');
    }

    public function store(Request $request){
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:4',
            'fa_logo' => 'required',
            'link' => 'required|url',
        ]);
        $link = Link::create($request->intersect('name', 'fa_logo', 'link'));
        return $this->respondWithItem($link, new LinkTransformer);
    }

    public function update(Request $request, Link $link){
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:4',
            'fa_logo' => 'required',
            'link' => 'required|url',
        ]);
        $this->hasPosition($request, $link);
        $link->update($request->intersect('name', 'fa_logo', 'link'));
        return $this->respondWithItem($link, new LinkTransformer);
    }

    protected function hasPosition($request, $link){
        if($request->has('position')){
            $entity = Link::where('position', $request->input('position'))->first();
            $link->moveBefore($entity);
        }
        return $this;
    }

    public function destroy(Link $link){
        $link->delete();
    }

    public function index(){
        $links = Link::sorted()->get();
        return $this->respondWithCollection($links, new LinkTransformer);
    }

    public function show(Link $link){
        return $this->respondWithItem($link, new LinkTransformer);
    }
}
