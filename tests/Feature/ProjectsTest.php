<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Storage;

class ProjectsTest extends TestCase
{
    use DatabaseMigrations;


    protected function setUp(){
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function creates_a_new_project_with_a_post_request(){
        $data = [
            'title' => 'My first Project',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.',
        ];
        $response = $this->postJson('/api/projects', $data); 
        $response->assertStatus(200);
        $this->assertCount(1, Project::all());
    }
    
    /** @test */
    public function get_sticky_projects_with_a_get_request(){
        $projects = factory(Project::class, 2)->create(['sticky' => true]);
        $project = factory(Project::class)->create();
        $response = $this->getJson('/api/projects/sticky')
            ->assertStatus(200)
            ->assertJson(['data' => 
                [
                    ['title' => $projects[0]->title]
                ]
            ]);

        $this->assertCount(2, Project::sticky()->get());
    }


    /** @test */
    public function shows_a_created_project_with_a_get_request(){
        $project = factory(Project::class)->create();
        $response = $this->getJson('/api/projects/'.$project->slug)
            ->assertStatus(200);
        $this->assertCount(1, Project::all());
    }

    /** @test */ 
    public function shows_a_list_of_projects_with_a_get_request(){
        $projects = factory(Project::class, 2)->create();
        $response = $this->getJson('/api/projects')
            ->assertStatus(200);
        $this->assertCount(2, Project::all());
    }

    /** @test */
    public function deletes_a_project_with_a_delete_request(){
        $project= factory(Project::class)->create();
        $response = $this->deleteJson('/api/projects/'.$project->slug)
            ->assertStatus(200);

        $this->assertCount(0, Project::all());
    }

    /** @test */
    public function updates_a_project_with_a_put_request(){
        $project = factory(Project::class)->create();

        $response = $this->putJson('/api/projects/'.$project->slug, ['title' => 'New Project'])
            ->assertStatus(200);
    }

    /** @test */
    public function deletes_a_project_field_with_a_put_request(){
        $project = factory(Project::class)->create();

        $response = $this->putJson('/api/projects/'.$project->slug, ['website' => ''])
            ->assertStatus(200)
            ->assertJson(['data' => [
                'website' => '']
            ]);
    }

    /** @test */
    public function changes_the_order_of_the_projects(){
        $projects = factory(Project::class, 2)->create();
        $projects[1]->moveBefore($projects[0]);
        $this->assertEquals($projects->last()->title, Project::sorted()->first()->title);
    }

    /** @test */
    public function changes_the_order_of_the_projects_with_a_put_request(){
        $projects = factory(Project::class, 2)->create();
        $newOrder = ['position' => 1];
        $response = $this->putJson('/api/projects/'.$projects[1]->slug, $newOrder)
            ->assertStatus(200);
        $this->assertEquals($projects->last()->title, Project::sorted()->first()->title);
    }

    /** @test */
    public function create_a_new_sticky_project(){
        $data = [
            'title' => 'My first Project',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.',
            'sticky' => true
        ];
        $response = $this->postJson('/api/projects', $data); 
        $response->assertStatus(200);
        $this->assertCount(1, Project::sticky()->get());
    }

    /** @test */
    public function creates_a_new_project_with_public_preview_image(){
        $file = $this->createFile('test.jpg');
        $project = factory(Project::class)->create();

        $response = $this->putJson('/api/projects/'.$project->slug, ['preview' => $file])
            ->assertStatus(200);

        $preview = storage_path('app/public/previews/').$project->slug.'.jpeg';
        $this->assertCount(1, Project::all());
        $this->assertFileExists($preview);
        unlink($preview);
    }

    /** @test */
    public function deletes_project_with_preview_image(){
        $file = $this->createFile('test.jpg');
        $project = factory(Project::class)->create();

        $response = $this->putJson('/api/projects/'.$project->slug, ['preview' => $file])
            ->assertStatus(200);

        $response = $this->deleteJson('/api/projects/'.$project->slug);

        $preview = storage_path('app/public/previews/').$project->slug.'.jpeg';
        $this->assertFileNotExists($preview);
    }

    /** @test */
    public function creates_a_new_project_with_a_zip_file(){
        $file = $this->createFile('test.zip');
        $project = factory(Project::class)->create();

        $response = $this->putJson('/api/projects/'.$project->slug, ['demo' => $file])
            ->assertStatus(200);

        $demo = storage_path('app/public/demos/').$project->slug.'/';
        $zip = storage_path('app/zips/').$project->slug.'.zip';

        $this->assertCount(1, Project::all());
        $this->assertFileExists($demo);
        $this->assertFileExists($zip);

        unlink($zip);
        $this->deleteFolderRecursive($demo);
    }

    /** @test */
    public function deletes_project_with_zip_file(){
        $file = $this->createFile('test.zip');
        $project = factory(Project::class)->create();

        $response = $this->putJson('/api/projects/'.$project->slug, ['demo' => $file])
            ->assertStatus(200);

        $response = $this->deleteJson('/api/projects/'.$project->slug);

        $demo = storage_path('app/public/demos/').$project->slug.'/';
        $zip = storage_path('app/zips/').$project->slug.'.zip';

        $this->assertFileNotExists($demo);
        $this->assertFileNotExists($zip);
    }

    /** @test */
    public function creates_a_new_project_with_a_image_file(){
        $file = $this->createFile('test.jpg');
        $project = factory(Project::class)->create();

        $response = $this->putJson('/api/projects/'.$project->slug, ['image' => $file])
            ->assertStatus(200);

        $image = storage_path('app/public/images/').$project->slug.'.jpeg';

        $this->assertCount(1, Project::all());
        $this->assertFileExists($image);

        unlink($image); 
    }

    protected function deleteFolderRecursive($dir){
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
        rmdir($dir);
    }
    protected function createFile($file){
        $stub = __DIR__.'/../stubs/'.$file;
        return new \Illuminate\Http\UploadedFile(
            $stub,
            $file,
            'image/jpeg',
            filesize($stub),
            null,
            true // for $test
        );    
    }
}
