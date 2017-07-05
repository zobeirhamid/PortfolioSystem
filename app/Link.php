<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use \Rutorika\Sortable\SortableTrait;
    protected $fillable = ['name', 'fa_logo', 'link'];
}
