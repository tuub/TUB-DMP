<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InputTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('input_types')->delete();
        
        DB::table('input_types')->insert(array (
            0 => 
            array (
                'id' => 'cf390574-b633-49f7-be9d-a6950ccff569',
                'identifier' => 'text',
                'title' => 'Textfeld, einzeilig',
                'category' => 'text',
                'is_active' => true,
            ),
            1 => 
            array (
                'id' => '6f0279f1-96b7-4437-9b8b-604f91d741f0',
                'identifier' => 'textarea',
                'title' => 'Textfeld, mehrzeilig',
                'category' => 'text',
                'is_active' => true,
            ),
            2 => 
            array (
                'id' => 'c60cc5eb-50a6-4893-9f6c-f5f4f0951255',
                'identifier' => 'select',
                'title' => 'Auswahlbox, einzeilig',
                'category' => 'option',
                'is_active' => false,
            ),
            3 => 
            array (
                'id' => 'b855ff02-5aea-4cfa-94a8-f8ac791b764f',
                'identifier' => 'multiselect',
                'title' => 'Auswahlbox, mehrzeilig',
                'category' => 'option',
                'is_active' => false,
            ),
            4 => 
            array (
                'id' => 'b2d63914-fbaa-4979-bfa3-97d908cbcdf6',
                'identifier' => 'list',
                'title' => 'Liste',
                'category' => 'list',
                'is_active' => false,
            ),
            5 => 
            array (
                'id' => 'a71a2194-0062-4581-a569-1c636e99c8e0',
                'identifier' => 'checkboxes',
                'title' => 'Checkboxen',
                'category' => 'option',
                'is_active' => false,
            ),
            6 => 
            array (
                'id' => '7d8935a9-fee4-47c1-bba7-244ef393a664',
                'identifier' => 'radiobuttons',
                'title' => 'Radiobuttons',
                'category' => 'option',
                'is_active' => false,
            ),
            7 => 
            array (
                'id' => '0e8cf415-1a0e-4768-b6b4-bf5f9e5c8366',
                'identifier' => 'date',
                'title' => 'Datumsfeld',
                'category' => 'text',
                'is_active' => false,
            ),
            8 => 
            array (
                'id' => '4d246f9f-9775-4917-b2d8-bdcb552559f3',
                'identifier' => 'daterange',
                'title' => 'Datumsbereich',
                'category' => 'range',
                'is_active' => false,
            ),
            9 => 
            array (
                'id' => '1cdfb5e8-ff1a-4f51-920b-4ea475087d9e',
                'identifier' => 'value',
                'title' => 'Wertefeld',
                'category' => 'text',
                'is_active' => false,
            ),
            10 => 
            array (
                'id' => '9c920bdc-17b1-42dc-be33-78bd87093067',
                'identifier' => 'valuerange',
                'title' => 'Wertebereich',
                'category' => 'range',
                'is_active' => false,
            ),
            11 => 
            array (
                'id' => '460ea0aa-506c-482c-91c7-93d6ca58a159',
                'identifier' => 'boolean',
                'title' => 'Ja/Nein',
                'category' => 'option',
                'is_active' => false,
            ),
            12 => 
            array (
                'id' => 'a91590a9-8ad7-40eb-96d8-855b4ab3d07d',
                'identifier' => 'plain',
            'title' => 'Plain (not editable)',
                'category' => 'text',
                'is_active' => false,
            ),
            13 => 
            array (
                'id' => '9561dc3c-b397-427b-8e79-22d64d6b4b30',
                'identifier' => 'person',
                'title' => 'Person',
                'category' => 'inputgroup',
                'is_active' => false,
            ),
            14 => 
            array (
                'id' => '6de81f08-7ba8-4956-bd96-32f339296dc8',
                'identifier' => 'organization',
                'title' => 'Organization',
                'category' => 'inputgroup',
                'is_active' => false,
            ),
            15 => 
            array (
                'id' => 'd623a35b-114e-4d2a-806c-5197e7e4e9ef',
                'identifier' => 'text_with_language',
                'title' => 'Text with Language Selection',
                'category' => 'inputgroup',
                'is_active' => false,
            ),
            16 => 
            array (
                'id' => 'ba4083c3-a48d-432b-aef8-890bb6420b46',
                'identifier' => 'textarea_with_language',
                'title' => 'Textarea with Language Selection',
                'category' => 'inputgroup',
                'is_active' => false,
            ),
            17 => 
            array (
                'id' => '3ef492b6-77cc-4b80-9ba8-7e2701182194',
                'identifier' => 'headline',
                'title' => 'Frage als Überschrift',
                'category' => 'headline',
                'is_active' => true,
            ),
        ));
        
        
    }
}