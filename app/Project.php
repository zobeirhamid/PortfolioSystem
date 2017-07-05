<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
class Project extends Model
{
    use Sluggable;
    use \Rutorika\Sortable\SortableTrait;
    protected $fillable = ['title', 'description', 'sticky', 'website', 'preview', 'image', 'demo', 'zip', 'tags', 'order'];
    public function sluggable(){
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    } 
    public function getRouteKeyName(){
        return 'slug';
    }

    protected static function boot(){
        parent::boot();

        static::addglobalScope('sticky', function(Builder $builder) {
            $builder->orderBy('sticky');
        });
    }

    public function scopeSticky($query){
        return $query->where('sticky', true);
    }

    public function scopeNotSticky($query){
        return $query->where('sticky', false);
    }

    public function addTags($tags){
        $tags = preg_split('/\s*,\s*/', $tags);

        $tagRelations = [];
        foreach($tags as $tag){
            if(!empty($tag)) $tagRelations[] = Tag::firstOrCreate(['name' => $tag])->name;
        }
        $this->categories()->sync($tagRelations);
    }

    public function addTag(Tag $tag){
        $this->categories()->attach($tag->name);
    }

    public function categories(){
        return $this->belongsToMany(Tag::class, 'project_tag', 'project_id', 'tag_name');
    }
}
