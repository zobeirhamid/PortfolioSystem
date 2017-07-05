<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Project;
use App\Tag;
use App\User;

class TagsTest extends TestCase
{
    use DatabaseMigrations;
    
    protected function setUp(){
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function project_can_add_a_tag(){
        $project = factory(Project::class)->create();
        $tag = factory(Tag::class)->create();
        $project->addTag($tag);
        $this->assertCount(1, $project->categories);
    }

    /** @test */
    public function create_a_tag_when_creating_a_post(){
        $data = ['title' => 'Test', 'description' => 'Hello World!', 'tags' => 'php'];
        $response = $this->postJson('/api/projects', $data);

        $project = Project::first();
        $this->assertCount(1, $project->categories);
    }

    /** @test */
    public function creates_one_tag_only_if_given_extra_comma(){
        $data = ['title' => 'Test', 'description' => 'Hello World!', 'tags' => 'php, '];
        $response = $this->postJson('/api/projects', $data);

        $project = Project::first();
        $this->assertCount(1, $project->categories);
    }

    /** @test */
    public function add_tags_to_existing_post(){
        $project = factory(Project::class)->create();
        $response = $this->putJson('/api/projects/'.$project->slug, ['tags' => 'php, html']);

        $this->assertCount(2, $project->categories);
    }

    /** @test */
    public function does_not_add_duplicate_tags_to_project(){
        $project = factory(Project::class)->create();
        $response = $this->putJson('/api/projects/'.$project->slug, ['tags' => 'php, php']);

        $this->assertCount(1, $project->categories);
    }

    /** @test */
    public function removes_tags_if_given_empty_tag(){
        $project = factory(Project::class)->create();
        $project->addTags('php, html');
        $response = $this->putJson('/api/projects/'.$project->slug, ['tags' => '']);
        $this->assertCount(0, $project->categories);

    }

    /** @test */
    public function one_tag_can_be_part_of_two_projects(){
        $tag = factory(Tag::class)->create();
        $projects = factory(Project::class, 2)->create();
        foreach($projects as $project){
            $project->addTag($tag);
        }

        $this->assertCount(2, $tag->projects);
    }

    /** @test */
    public function retrieve_all_tags_with_projects(){
        $tag = factory(Tag::class)->create();
        $projects = factory(Project::class, 2)->create();
        foreach($projects as $project){
            $project->addTag($tag);
        }

        $response = $this->getJson('/api/categories')
            ->assertStatus(200)
            ->assertJson([]);

        $this->assertCount(2, $tag->projects);
    }

    /** @test */
    public function retrieve_single_tag_with_projects(){
        $tag = factory(Tag::class)->create();
        $projects = factory(Project::class, 2)->create();
        foreach($projects as $project){
            $project->addTag($tag);
        }

        $response = $this->getJson('/api/categories/'.$tag->name)
            ->assertStatus(200)
            ->assertJson([]);

        $this->assertCount(2, $tag->projects);
        
    }
}
