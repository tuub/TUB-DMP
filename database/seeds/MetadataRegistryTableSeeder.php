<?php

use Illuminate\Database\Seeder;
use App\MetadataRegistry;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class MetadataRegistryTableSeeder extends Seeder
{
    public function run()
    {
        MetadataRegistry::create([
            'id' => 1,
            'namespace' => 'project',
            'identifier' => 'title',
            'title' => 'Project Title',
            'description' => 'The title of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 2,
            'namespace' => 'project',
            'identifier' => 'abstract',
            'title' => 'Project Abstract',
            'description' => 'The desription of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 3,
            'namespace' => 'project',
            'identifier' => 'begin',
            'title' => 'Project Begin',
            'description' => 'The begin date of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 4,
            'namespace' => 'project',
            'identifier' => 'end',
            'title' => 'Project End',
            'description' => 'The end date of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 5,
            'namespace' => 'project',
            'identifier' => 'stage',
            'title' => 'Project Stage',
            'description' => 'The stage of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 6,
            'namespace' => 'project',
            'identifier' => 'leader',
            'title' => 'Principal Investigator',
            'description' => 'The principal investigator of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 7,
            'namespace' => 'project',
            'identifier' => 'members',
            'title' => 'Other Principal Investigator(s)',
            'description' => 'Other principal investigator(s) of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 8,
            'namespace' => 'project',
            'identifier' => 'partner',
            'title' => 'External Project Partner(s)',
            'description' => 'The external project partner(s) of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 9,
            'namespace' => 'project',
            'identifier' => 'funding_source',
            'title' => 'Funding Source',
            'description' => 'The funding source of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 10,
            'namespace' => 'project',
            'identifier' => 'funding_program',
            'title' => 'Funding Program',
            'description' => 'The funding program of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 11,
            'namespace' => 'project',
            'identifier' => 'grant_reference_number',
            'title' => 'Grant Reference Number',
            'description' => 'The grant reference number of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 12,
            'namespace' => 'project',
            'identifier' => 'project_management_organisation',
            'title' => 'Project Management Organisation',
            'description' => 'The project management organisation of the research project.',
        ]);

        MetadataRegistry::create([
            'id' => 13,
            'namespace' => 'project',
            'identifier' => 'project_data_contact',
            'title' => 'Project Data Contact',
            'description' => 'The project data contact of the research project.',
        ]);
    }
}
