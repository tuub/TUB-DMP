<?php

use Illuminate\Database\Seeder;
use App\ContentType;

class ContentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContentType::create([
            'id' => 1,
            'identifier' => 'text_simple',
            'title' => 'Text',
            'structure' => [],
            'input_type_id' => 1,
        ]);

        ContentType::create([
            'id' => 2,
            'identifier' => 'textarea_simple',
            'title' => 'Textarea',
            'structure' => [],
            'input_type_id' => 2,
        ]);

        ContentType::create([
            'id' => 3,
            'identifier' => 'date',
            'title' => 'Datum',
            'structure' => [],
            'input_type_id' => 8,
        ]);

        ContentType::create([
            'id' => 4,
            'identifier' => 'person',
            'title' => 'Person',
            'structure' => ['firstname' => '', 'lastname' => '', 'email' => '', 'uri' => ''],
            'input_type_id' => 14,
        ]);

        ContentType::create([
            'id' => 5,
            'identifier' => 'organization',
            'title' => 'Organization',
            'structure' => [],
            'input_type_id' => 15,
        ]);

        ContentType::create([
            'id' => 6,
            'identifier' => 'list',
            'title' => 'List',
            'structure' => [],
            'input_type_id' => 5,
        ]);

        ContentType::create([
            'id' => 7,
            'identifier' => 'value',
            'title' => 'Value',
            'structure' => [],
            'input_type_id' => 10,
        ]);

        ContentType::create([
            'id' => 8,
            'identifier' => 'value_range',
            'title' => 'Value Range',
            'structure' => ['alpha' => '', 'omega' => ''],
            'input_type_id' => 11,
        ]);

        ContentType::create([
            'id' => 9,
            'identifier' => 'date_range',
            'title' => 'Date Range',
            'structure' => ['begin' => '', 'end' => ''],
            'input_type_id' => 9,
        ]);

        ContentType::create([
            'id' => 10,
            'identifier' => 'text_with_language',
            'title' => 'Text with language selector',
            'structure' => ['content' => '', 'language' => ''],
            'input_type_id' => 16,
        ]);

        ContentType::create([
            'id' => 11,
            'identifier' => 'textarea_with_language',
            'title' => 'Textarea with language selector',
            'structure' => ['content' => '', 'language' => ''],
            'input_type_id' => 17,
        ]);

        ContentType::create([
            'id' => 99,
            'identifier' => 'plain',
            'title' => 'Plain Text',
            'structure' => [],
            'input_type_id' => 99,
        ]);

    }
}
