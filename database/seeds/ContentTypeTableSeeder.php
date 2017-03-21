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
            'identifier' => 'text',
            'title' => 'Text',
            'input_type_id' => 1,
        ]);

        ContentType::create([
            'id' => 2,
            'identifier' => 'textarea',
            'title' => 'Textarea',
            'input_type_id' => 2,
        ]);

        ContentType::create([
            'id' => 3,
            'identifier' => 'date',
            'title' => 'Datum',
            'input_type_id' => 8,
        ]);

        ContentType::create([
            'id' => 4,
            'identifier' => 'person',
            'title' => 'Person',
            'input_type_id' => 14,
        ]);

        ContentType::create([
            'id' => 5,
            'identifier' => 'organization',
            'title' => 'Organization',
            'input_type_id' => 15,
        ]);

        ContentType::create([
            'id' => 6,
            'identifier' => 'list',
            'title' => 'List',
            'input_type_id' => 5,
        ]);

        ContentType::create([
            'id' => 99,
            'identifier' => 'plain',
            'title' => 'Plain Text',
            'input_type_id' => 99,
        ]);

    }
}
