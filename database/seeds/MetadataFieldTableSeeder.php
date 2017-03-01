<?php

use Illuminate\Database\Seeder;
use App\MetadataField;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class MetadataFieldTableSeeder extends Seeder
{
    public function run()
    {
        MetadataField::create([
            'id' => 1,
            'namespace' => 'project',
            'identifier' => 'title',
            'name' => 'Project Title',
            'description' => 'The title of the research project.',
        ]);

        MetadataField::create([
            'id' => 2,
            'namespace' => 'project',
            'identifier' => 'begin',
            'name' => 'Project Begin',
            'description' => 'The begin date of the research project.',
        ]);

        MetadataField::create([
            'id' => 3,
            'namespace' => 'project',
            'identifier' => 'end',
            'name' => 'Project End',
            'description' => 'The end date of the research project.',
        ]);
    }
}
