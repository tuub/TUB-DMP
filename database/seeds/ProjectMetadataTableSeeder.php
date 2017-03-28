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
            'metadata_registry_id' => 1,
            //'content' => ['value' => ['de' => 'SFB 1026 - Sustainable Manufacturing', 'en' => 'SFB 1026 - Sustainable Manufacturing']],
            'content' => ['de' => 'SFB 1026 - Sustainable Manufacturing', 'en' => 'SFB 1026 - Sustainable Manufacturing'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 3,
            //'content' => ['value' => '2015-01-01'],
            'content' => ['2015-01-01'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 4,
            //'content' => ['value' => '2017-12-31'],
            'content' => ['2017-12-31'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 7,
            'content' => ['Rainer Rauball', 'Winnie Schäfer','Laurenz-Günther Köstner'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 9,
            'content' => ['DFG', 'BMBF'],
        ]);
    }
}
