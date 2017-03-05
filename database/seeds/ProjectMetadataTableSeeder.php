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
            'content' => 'SFB 1026 - Sustainable Manufacturing',
            'language' => 'de'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 1,
            'content' => 'SFB 1026 - Sustainable Manufacturing',
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
            'content' => '2017-12-31'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 7,
            'content' => 'Rainer Rauball'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 7,
            'content' => 'Winnie Schäfer'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 7,
            'content' => 'Laurenz-Günther Köstner'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 9,
            'content' => 'DFG'
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_field_id' => 9,
            'content' => 'BMBF'
        ]);




    }
}
