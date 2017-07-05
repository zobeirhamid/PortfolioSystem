<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tag extends Model
{
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $fillable = ['name'];
    public $timestamps = false;

    public function projects(){
        return $this->belongsToMany(Project::class, 'project_tag', 'tag_name', 'project_id');
    }
}
