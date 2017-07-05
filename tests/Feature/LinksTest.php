<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Link;
use App\User;

class LinksTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(){
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function creates_a_new_link(){
        $data = [
            'name' => 'Resume',
            'fa_logo' => 'file-text-o',
            'link' => 'http://zobeirhamid.com'
        ];
        $response = $this->postJson('/api/links', $data);
        $response->assertStatus(200);
        $this->assertCount(1, Link::all());
    }

    /** @test */
    public function edits_an_existing_link(){
        $data = ['name' => 'Resume'];
        $link = factory(Link::class)->create();

        $response = $this->putJson('/api/links/'.$link->id, $data);
        $response->assertStatus(200);
        $response->assertJson(
            ['data' => 
                [
                    'name' => 'Resume'
                ]
            ]
        );
    }

    /** @test */
    public function deletes_an_existing_link(){
        $link = factory(Link::class)->create();
        $response = $this->deleteJson('/api/links/'.$link->id);
        $response->assertStatus(200);
        $this->assertCount(0, Link::all());
    }

    /** @test */
    public function shows_a_list_of_links(){
        $links = factory(Link::class, 2)->create();
        $response = $this->getJson('/api/links');
        $response->assertStatus(200);
        $response->assertJson(
            ['data' => 
                [
                    [
                        'name' => $links->first()->name
                    ]
                ]
            ]
        );
    }

    /** @test */
    public function shows_a_single_link(){
        $link = factory(Link::class)->create();
        $response = $this->getJson('/api/links/'.$link->id);
        $response->assertStatus(200);
        $response->assertJson(
            ['data' => 
                [
                    'name' => $link->name
                ]
            ]
        );
        
    }
}
