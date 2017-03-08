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
        ]);

        ContentType::create([
            'id' => 2,
            'identifier' => 'date',
            'title' => 'Datum',
        ]);

        ContentType::create([
            'id' => 3,
            'identifier' => 'person',
            'title' => 'Person',
        ]);

        ContentType::create([
            'id' => 4,
            'identifier' => 'organization',
            'title' => 'Organization',
        ]);

    }
}
