<?php
namespace App\Transformers;

use App\Tag;
use App\Project;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\Storage;

class TagTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'projects'
    ];
    public function transform(Tag $tag){
        return [
            'name' => $tag->name,

            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/api/projects/categories/'.$tag->name
                ]
            ]
        ];
    }

    public function includeProjects(Tag $tag){
        $projects = $tag->projects()->sorted()->notSticky()->get();
        return $this->collection($projects, new ProjectTransformer);
    }
}

