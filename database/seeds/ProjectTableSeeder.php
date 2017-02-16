<?php

use Illuminate\Database\Seeder;
use App\Project;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProjectTableSeeder extends Seeder
{
    public function run()
    {
        //TestDummy::times(1)->create('App\Project');
        Project::create([
            'id' => 1,
            'identifier' => 'DMP-123',
            'user_id' => 1,
            'data_source_id' => 1,
        ]);

        Project::create([
            'id' => 2,
            'identifier' => 'DMP-123-01',
            'parent_id' => 1,
            'user_id' => 1,
            'data_source_id' => 1,
        ]);

        Project::create([
            'id' => 3,
            'identifier' => 'DMP-123-02',
            'parent_id' => 1,
            'user_id' => 1,
            'data_source_id' => 1,
        ]);
    }
}