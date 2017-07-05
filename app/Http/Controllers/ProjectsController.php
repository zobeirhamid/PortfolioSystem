<?php

namespace App\Http\Controllers;

use App\Project;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Transformers\ProjectTransformer;

class ProjectsController extends ApiController
{
    protected function setMiddlewareMethods(){
        $this->middleware('auth:api')->except('index', 'show', 'sticky');
    }

    public function index()
    {
        $projects = Project::sorted()->notSticky()->get();
        return $this->respondWithCollection($projects, new ProjectTransformer);
    }

    public function sticky(){
        $projects = Project::sorted()->sticky()->get();
        return $this->respondWithCollection($projects, new ProjectTransformer);
    }

    public function show(Project $project)
    {
        return $this->respondWithItem($project, new ProjectTransformer);
    }

    public function destroy(Project $project)
    {
        if($project->preview) Storage::delete($project->preview);
        if($project->zip) Storage::disk('local')->delete($project->zip);
        if($project->demo) Storage::deleteDirectory($project->demo);
        $project->delete();
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|min:4',
            'description' => 'required',
            'preview' => 'mimes:jpeg,bmp,png,gif',
            'image' => 'mimes:jpeg,bmp,png,gif',
            'demo' => 'mimes:zip',
            'website' => 'url|nullable',
            'tags' => 'string|nullable',
            'sticky' => 'boolean'
        ]);
        if ($validator->fails()) return $this->errorWrongArgs('Wrong input',$this->parseErrors($validator));

        $project = Project::create($request->intersect('title', 'description', 'website', 'tags', 'sticky'));
        $this->hasUploads($request, $project)
            ->hasTags($request, $project);

        return $this->respondWithItem($project, new ProjectTransformer);
    }

    public function update(Request $request, Project $project)
    {
        $validator = \Validator::make($request->all(), [
            'preview' => 'mimes:jpeg,bmp,png,gif',
            'image' => 'mimes:jpeg,bmp,png,gif',
            'demo' => 'mimes:zip',
            'website' => 'url|nullable',
            'tags' => 'string|nullable',
            'position' => 'integer'
        ]);
        if ($validator->fails()) return $this->errorWrongArgs('Wrong input',$this->parseErrors($validator));

        $this->hasUploads($request, $project)
            ->hasTags($request, $project)
            ->hasWebsite($request, $project)
            ->hasPosition($request, $project);

        $project->update($request->intersect('title', 'description', 'website','tags', 'sticky'));

        return $this->respondWithItem($project, new ProjectTransformer);
    }

    protected function hasPosition($request, $project){
        if($request->has('position')){
            $entity = Project::where('position', $request->input('position'))->first();
            $project->moveBefore($entity);
        }
        return $this;
    }

    protected function hasWebsite($request, $project){
        if($request->exists('website') && !$request->has('website')) {
            $project->website = '';
        }
        return $this;
    }

    protected function hasTags($request, $project){
        if($request->has('tags')) $project->addTags($request->input('tags'));
        if($request->exists('tags') && !$request->has('tags')) {
            $project->addTags('');
            $project->tags = '';
        }
        return $this;
    }


    protected function hasUploads($request, $project){
        $imageOptimizer = app('Approached\LaravelImageOptimizer\ImageOptimizer');
        if($request->hasFile('preview')) $imageOptimizer->optimizeUploadedImageFile($request->file('preview'));
        if($request->hasFile('image')) $imageOptimizer->optimizeUploadedImageFile($request->file('image'));
        return $this->hasFilePreview($request, $project)
            ->hasFileImage($request, $project)
            ->hasFileDemo($request, $project);
    }

    protected function hasFilePreview(Request $request, Project $project){
        $data = $this->uploadFile($request, 'preview', 'previews', $project->slug);
        //if(!empty($data) && $project->preview) Storage::delete($project->preview);
        $project->update($data);
        return $this;
    }

    protected function hasFileImage(Request $request, Project $project){
        $data = $this->uploadFile($request, 'image', 'images', $project->slug);
        //if(!empty($data) && $project->image) Storage::delete($project->image);
        $project->update($data);
        return $this;
    }

    protected function hasFileDemo(Request $request, Project $project){
        $data = $this->uploadfile($request, 'demo', 'zips', $project->slug, 'zip', 'local');
        if(!empty($data) && $project->zip) {
            //Storage::disk('local')->delete($project->zip);
            //if($project->demo) Storage::deleteDirectory($project->demo);
        }
        $project->update($data);

        if(!empty($data)) $project->update($this->extractZip($project));
        return $this;
    }

    protected function uploadFile(Request $request, $file, $path, $slug, $field = null, $drive = 'public'){
        $data = [];
        if(!$field) $field = $file;

        if($request->hasFile($file) && $request->file($file)->isValid()){
            $data[$field] = $request->file($file)->storeAs($path, $slug.'.'.$request->file($file)->extension(), $drive);
        }
        return $data;
    }

    protected function extractZip(Project $project){
        $absolutePathToZip = storage_path('app/').$project->zip;
        $destination = 'demos/'.$project->slug;

        \Chumper\Zipper\Facades\Zipper::make($absolutePathToZip)->extractTo(storage_path('app/public/').$destination);
        $data['demo'] = $destination;
        return $data;
    }
}


