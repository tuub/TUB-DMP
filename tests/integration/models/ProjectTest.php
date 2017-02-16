<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Project;

class ProjectTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;

    protected $project;

    /**
     * @return mixed
     */
    public function setUp()
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        $this->project = Mockery::mock('App\Project');
        factory(Project::class, 3)->create();
    }

    public function tearDown()
    {
        $this->artisan('migrate:refresh');
        Mockery::close();
    }

    public function testIndex()
    {
        $this->call('GET', 'admin/project');
        $this->assertViewHas('projects');
    }

    public function testBoo()
    {
        $data = [
            'identifier' => 'TEST-01',
            'user_id' => 1,
        ];

        $this->project
             ->shouldReceive('create')
             ->once()
             ->with($data);

        $this->app->instance('Project', $this->project);

        $this->project->create($data);

        $this->call('POST', 'project', $data);
    }

    // TODO: Fix!
    /*
    public function testLaraCastsExample()
    {
        // Given
        $data = [
            'is_prefilled' => 1
        ];
        factory(Project::class, 5)->create();
        $prefilled_projects = factory(Project::class)->create($data);

        // When
        $projects = $this->project->prefilled();

        // Then
        $this->assertEquals($prefilled_projects->id, $projects->first()->id);
    }
    */

    public function testCanCreateProject()
    {
        $data = [
            'identifier' => 'TEST-01',
            'user_id' => 1,
        ];
        $this->call('POST', 'admin/project', $data);
        $this->assertRedirectedTo('admin/project');
    }

    public function testCannotCreateProject()
    {
        $data = [
            'identifier' => 'TEST-01',
        ];
        $this->call('POST', 'admin/project', $data);
        $this->assertSessionHasErrors();
    }

    public function testCannotCreateProjectIdentifierTwice()
    {
        $data = [
            'identifier' => 'TEST-02',
            'user_id' => 1,
        ];
        $this->call('POST', 'admin/project', $data);
        $this->call('POST', 'admin/project', $data);
        $this->assertSessionHasErrors();
    }

    // TODO: Fix!
    /*
    public function testEditProject()
    {
        $data = [
            'identifier' => 'TEST-02',
            'user_id' => 1,
        ];
        //$this->app->instance('App\Project' , $this->project);
        $this->project
            ->shouldReceive('find')
            ->once()
            ->andReturn($data);


        $data = $this->project->find(1);
        $this->call('POST', 'admin/project/edit', $data);
        $this->assertResponseOk();
    }
    */
}
