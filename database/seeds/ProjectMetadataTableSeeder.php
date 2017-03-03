<?php

use Illuminate\Database\Seeder;
use App\ProjectMetadata;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProjectMetadataTableSeeder extends Seeder
{
    public function run()
    {
        //TestDummy::times(1)->create('App\Project');
        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 1,
            'content' => 'Mein Projekt-Titel',
            'language' => 'de'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 1,
            'content' => 'My Project Title',
            'language' => 'en'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 3,
            'content' => '2015-01-01'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 4,
            'content' => '2017-31-12'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 9,
            'content' => 'DFG'
        ]);



    }
}
