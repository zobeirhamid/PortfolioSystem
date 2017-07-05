<?php
namespace App\Transformers;

use App\Project;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\Storage;

class ProjectTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['categories'];
    public function transform(Project $project){
        return [
            'id' => (int) $project->id,
            'slug' => $project->slug,
            'title' => $project->title,
            'description' => $project->description,
            'preview' => $project->preview ? Storage::url($project->preview) : '',
            'image' => $project->image ? Storage::url($project->image) : '',
            'demo' => $project->demo ? Storage::url($project->demo).'/index.html' : '',
            'website' => $project->website,
            'sticky' => (bool) $project->sticky,
            'tags' => $project->tags,
            'position' => (int) $project->position,

            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/api/projects/'.$project->slug
                ]
            ]
        ];
    }


    public function includeCategories(Project $project){
        $categories = $project->categories;
        return $this->collection($categories, new TagTransformer);
    }
}
