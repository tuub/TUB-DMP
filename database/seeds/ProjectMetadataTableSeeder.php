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
            'content' => ['de' => 'SFB 1026 - Sustainable Manufacturing', 'en' => 'SFB 1026 - Sustainable Manufacturing'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 2,
            'content' => ['de' => 'Lorem Ipsum', 'en' => 'Foo Bar Foobar'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 3,
            'content' => ['2015-01-01'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 4,
            'content' => ['2017-12-31'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 5,
            'content' => ['First Draft'],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 6,
            'content' => [
                ['firstname' => 'José', 'lastname' => 'Mourinho', 'email' => 'jose@mourinho.org', 'uri' => 'http://chelseafc.co.uk'],
            ],
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 7,
            'content' => [
                ['firstname' => 'Rainer', 'lastname' => 'Rauball', 'email' => 'rainer@rauball.de', 'uri' => 'http://www.schwatzgelb.de'],
                ['firstname' => 'Winnie', 'lastname' => 'Schäfer', 'email' => 'winnie@winnie.com', 'uri' => 'https://ksc.oleole.de'],
                ['firstname' => 'Laurenz-Günther', 'lastname' => 'Köstner', 'email' => '', 'uri' => ''],
            ]
        ]);

        ProjectMetadata::create([
            'project_id' => 1,
            'metadata_registry_id' => 9,
            'content' => ['DFG', 'BMBF'],
        ]);
    }
}