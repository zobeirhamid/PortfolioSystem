<?php
namespace App\Transformers;

use App\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link){
        return [
            'id' => $link->id,
            'name' => $link->name,
            'fa_logo' => $link->fa_logo,
            'link' => $link->link,
            'position' => (int) $link->position,

            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/api/links/'.$link->id
                ]
            ]
        ];
    }
}


