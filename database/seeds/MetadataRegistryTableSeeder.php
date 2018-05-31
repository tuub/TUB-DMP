<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetadataRegistryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('metadata_registry')->delete();
        
        DB::table('metadata_registry')->insert(array (
            0 => 
            array (
                'id' => '70345ab8-a5e9-4559-8acc-da081a1ac6e0',
                'namespace' => 'project',
                'identifier' => 'title',
                'title' => 'Project Title',
                'description' => 'The title of the research project.',
                'content_type_id' => '59148f88-b993-47c9-bd48-46f65c0b9e25',
                'is_multiple' => true,
            ),
            1 => 
            array (
                'id' => '7948ccd8-775d-4e71-bc61-3e2c12bf138a',
                'namespace' => 'project',
                'identifier' => 'stage',
                'title' => 'Project Stage',
                'description' => 'The stage of the research project.',
                'content_type_id' => '59148f88-b993-47c9-bd48-46f65c0b9e25',
                'is_multiple' => true,
            ),
            2 => 
            array (
                'id' => 'e78b42ff-689f-4fd5-aad7-1d6f68d508b0',
                'namespace' => 'project',
                'identifier' => 'abstract',
                'title' => 'Project Abstract',
                'description' => 'The desription of the research project.',
                'content_type_id' => '105ba5d3-1a2e-426b-97e5-d2357fb6fb13',
                'is_multiple' => true,
            ),
            3 => 
            array (
                'id' => 'd2b5eb4a-581c-47d3-9ac0-3552b2d7c1d1',
                'namespace' => 'project',
                'identifier' => 'begin',
                'title' => 'Project Begin',
                'description' => 'The begin date of the research project.',
                'content_type_id' => '503fbcf8-e60a-4439-9aba-aeea2b5a1d9e',
                'is_multiple' => false,
            ),
            4 => 
            array (
                'id' => 'a486e7b8-5897-43e9-91c6-85a3b1887f86',
                'namespace' => 'project',
                'identifier' => 'end',
                'title' => 'Project End',
                'description' => 'The end date of the research project.',
                'content_type_id' => '503fbcf8-e60a-4439-9aba-aeea2b5a1d9e',
                'is_multiple' => false,
            ),
            5 => 
            array (
                'id' => '49599b55-9f8c-492a-a1c1-7bd3ec35cdae',
                'namespace' => 'project',
                'identifier' => 'leader',
                'title' => 'Principal Investigator',
                'description' => 'The principal investigator of the research project.',
                'content_type_id' => '884db32d-4dff-4c3c-9cc8-3cfa3e6da9e1',
                'is_multiple' => true,
            ),
            6 => 
            array (
                'id' => '0923abf9-b514-4356-b3a4-4c0201813c21',
                'namespace' => 'project',
                'identifier' => 'member',
                'title' => 'Other Principal Investigator',
            'description' => 'Other principal investigator(s) of the research project.',
                'content_type_id' => '884db32d-4dff-4c3c-9cc8-3cfa3e6da9e1',
                'is_multiple' => true,
            ),
            7 => 
            array (
                'id' => '0e086914-9a54-406f-a5ae-5386250b8652',
                'namespace' => 'project',
                'identifier' => 'partner',
                'title' => 'External Project Partner',
            'description' => 'The external project partner(s) of the research project.',
                'content_type_id' => '4c0004d8-07cc-4a94-bd1a-ae7e91cd8490',
                'is_multiple' => true,
            ),
            8 => 
            array (
                'id' => '5c87b485-b672-4e96-9d45-c69cb6cdb02b',
                'namespace' => 'project',
                'identifier' => 'funding_source',
                'title' => 'Funding Source',
                'description' => 'The funding source of the research project.',
                'content_type_id' => '4c0004d8-07cc-4a94-bd1a-ae7e91cd8490',
                'is_multiple' => true,
            ),
            9 => 
            array (
                'id' => 'a5dcd072-8217-42ea-a8bd-664021afc53f',
                'namespace' => 'project',
                'identifier' => 'funding_program',
                'title' => 'Funding Program',
                'description' => 'The funding program of the research project.',
                'content_type_id' => 'cf29c871-3c1a-46e9-bb41-74226e369ce5',
                'is_multiple' => true,
            ),
            10 => 
            array (
                'id' => '7f605d6d-f25b-432e-9fe0-f3f6b97a6f39',
                'namespace' => 'project',
                'identifier' => 'grant_reference_number',
                'title' => 'Grant Reference Number',
                'description' => 'The grant reference number of the research project.',
                'content_type_id' => 'cf29c871-3c1a-46e9-bb41-74226e369ce5',
                'is_multiple' => true,
            ),
            11 => 
            array (
                'id' => 'dfdc34d5-92c0-4f5e-a59d-18828bf956ea',
                'namespace' => 'project',
                'identifier' => 'project_management_organisation',
                'title' => 'Project Management Organisation',
                'description' => 'The project management organisation of the research project.',
                'content_type_id' => 'cf29c871-3c1a-46e9-bb41-74226e369ce5',
                'is_multiple' => false,
            ),
            12 => 
            array (
                'id' => '244cdfaf-9c79-47ce-8183-8c0884447fd4',
                'namespace' => 'project',
                'identifier' => 'project_data_contact',
                'title' => 'Project Data Contact',
                'description' => 'The project data contact of the research project.',
                'content_type_id' => 'cf29c871-3c1a-46e9-bb41-74226e369ce5',
                'is_multiple' => false,
            ),
        ));
        
        
    }
}