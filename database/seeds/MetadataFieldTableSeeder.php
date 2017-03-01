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
            'identifier' => 'abstract',
            'name' => 'Project Abstract',
            'description' => 'The desription of the research project.',
        ]);

        MetadataField::create([
            'id' => 3,
            'namespace' => 'project',
            'identifier' => 'begin',
            'name' => 'Project Begin',
            'description' => 'The begin date of the research project.',
        ]);

        MetadataField::create([
            'id' => 4,
            'namespace' => 'project',
            'identifier' => 'end',
            'name' => 'Project End',
            'description' => 'The end date of the research project.',
        ]);

        MetadataField::create([
            'id' => 5,
            'namespace' => 'project',
            'identifier' => 'stage',
            'name' => 'Project Stage',
            'description' => 'The stage of the research project.',
        ]);

        MetadataField::create([
            'id' => 6,
            'namespace' => 'project',
            'identifier' => 'leader',
            'name' => 'Principal Investigator',
            'description' => 'The principal investigator of the research project.',
        ]);

        MetadataField::create([
            'id' => 7,
            'namespace' => 'project',
            'identifier' => 'members',
            'name' => 'Other Principal Investigator(s)',
            'description' => 'Other principal investigator(s) of the research project.',
        ]);

        MetadataField::create([
            'id' => 8,
            'namespace' => 'project',
            'identifier' => 'partner',
            'name' => 'External Project Partner(s)',
            'description' => 'The external project partner(s) of the research project.',
        ]);

        MetadataField::create([
            'id' => 9,
            'namespace' => 'project',
            'identifier' => 'funding_source',
            'name' => 'Funding Source',
            'description' => 'The funding source of the research project.',
        ]);

        MetadataField::create([
            'id' => 10,
            'namespace' => 'project',
            'identifier' => 'funding_program',
            'name' => 'Funding Program',
            'description' => 'The funding program of the research project.',
        ]);

        MetadataField::create([
            'id' => 11,
            'namespace' => 'project',
            'identifier' => 'grant_reference_number',
            'name' => 'Grant Reference Number',
            'description' => 'The grant reference number of the research project.',
        ]);

        MetadataField::create([
            'id' => 12,
            'namespace' => 'project',
            'identifier' => 'project_management_organisation',
            'name' => 'Project Management Organisation',
            'description' => 'The project management organisation of the research project.',
        ]);

        MetadataField::create([
            'id' => 13,
            'namespace' => 'project',
            'identifier' => 'project_data_contact',
            'name' => 'Project Data Contact',
            'description' => 'The project data contact of the research project.',
        ]);
    }
}
