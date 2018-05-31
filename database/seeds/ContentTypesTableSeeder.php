<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('content_types')->delete();
        
        DB::table('content_types')->insert(array (
            0 => 
            array (
                'id' => 'cf29c871-3c1a-46e9-bb41-74226e369ce5',
                'identifier' => 'text_simple',
                'title' => 'Text',
                'structure' => '[]',
                'input_type_id' => 'cf390574-b633-49f7-be9d-a6950ccff569',
                'is_active' => true,
            ),
            1 => 
            array (
                'id' => '9c156cf3-0034-4c4b-a30a-d8eb03a695d3',
                'identifier' => 'textarea_simple',
                'title' => 'Textarea',
                'structure' => '[]',
                'input_type_id' => '6f0279f1-96b7-4437-9b8b-604f91d741f0',
                'is_active' => true,
            ),
            2 => 
            array (
                'id' => '503fbcf8-e60a-4439-9aba-aeea2b5a1d9e',
                'identifier' => 'date',
                'title' => 'Datum',
                'structure' => '[]',
                'input_type_id' => '0e8cf415-1a0e-4768-b6b4-bf5f9e5c8366',
                'is_active' => false,
            ),
            3 => 
            array (
                'id' => '884db32d-4dff-4c3c-9cc8-3cfa3e6da9e1',
                'identifier' => 'person',
                'title' => 'Person',
                'structure' => '{"firstname":"","lastname":"","email":"","uri":""}',
                'input_type_id' => '9561dc3c-b397-427b-8e79-22d64d6b4b30',
                'is_active' => false,
            ),
            4 => 
            array (
                'id' => '4c0004d8-07cc-4a94-bd1a-ae7e91cd8490',
                'identifier' => 'organization',
                'title' => 'Organization',
                'structure' => '[]',
                'input_type_id' => '6de81f08-7ba8-4956-bd96-32f339296dc8',
                'is_active' => false,
            ),
            5 => 
            array (
                'id' => 'a3414c9a-0175-47a9-9284-ae4f76d0fc92',
                'identifier' => 'list',
                'title' => 'List',
                'structure' => '[]',
                'input_type_id' => 'b2d63914-fbaa-4979-bfa3-97d908cbcdf6',
                'is_active' => false,
            ),
            6 => 
            array (
                'id' => 'd733c3f6-342a-4fef-959c-cfb522f3d274',
                'identifier' => 'value',
                'title' => 'Value',
                'structure' => '[]',
                'input_type_id' => '1cdfb5e8-ff1a-4f51-920b-4ea475087d9e',
                'is_active' => false,
            ),
            7 => 
            array (
                'id' => '4b822c78-7ede-4c7d-9f34-af063eafca0f',
                'identifier' => 'value_range',
                'title' => 'Value Range',
                'structure' => '{"alpha":"","omega":""}',
                'input_type_id' => '9c920bdc-17b1-42dc-be33-78bd87093067',
                'is_active' => false,
            ),
            8 => 
            array (
                'id' => '7ac305b4-5e09-48f0-8282-eac3f7c5a63b',
                'identifier' => 'date_range',
                'title' => 'Date Range',
                'structure' => '{"begin":"","end":""}',
                'input_type_id' => '4d246f9f-9775-4917-b2d8-bdcb552559f3',
                'is_active' => false,
            ),
            9 => 
            array (
                'id' => '59148f88-b993-47c9-bd48-46f65c0b9e25',
                'identifier' => 'text_with_language',
                'title' => 'Text with language selector',
                'structure' => '{"content":"","language":""}',
                'input_type_id' => 'd623a35b-114e-4d2a-806c-5197e7e4e9ef',
                'is_active' => false,
            ),
            10 => 
            array (
                'id' => '105ba5d3-1a2e-426b-97e5-d2357fb6fb13',
                'identifier' => 'textarea_with_language',
                'title' => 'Textarea with language selector',
                'structure' => '{"content":"","language":""}',
                'input_type_id' => 'ba4083c3-a48d-432b-aef8-890bb6420b46',
                'is_active' => false,
            ),
            11 => 
            array (
                'id' => '743a0a0a-c522-4cfe-adb4-c38028c966b0',
                'identifier' => 'plain',
                'title' => 'Plain Text',
                'structure' => '[]',
                'input_type_id' => '3ef492b6-77cc-4b80-9ba8-7e2701182194',
                'is_active' => true,
            ),
        ));
        
        
    }
}