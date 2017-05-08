<?php

use Illuminate\Database\Seeder;
use App\DataSourceMapping;
// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class DataSourceMappingTableSeeder extends Seeder
{
    public function run()
    {
        //TestDummy::times(1)->create('App\DataSource');
        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Langtitel_dt'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 1,
            'target_content' => ['content' => 'CONTENT', 'language' => 'de']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Langtitel_en'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 1,
            'target_content' => ['content' => 'CONTENT', 'language' => 'en']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Abstract_dt'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 2,
            'target_content' => ['content' => 'CONTENT', 'language' => 'de']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Abstract_en'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 2,
            'target_content' => ['content' => 'CONTENT', 'language' => 'en']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Laufzeit_von'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 3,
            'target_content' => ['CONTENT']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Laufzeit_bis'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 4,
            'target_content' => ['CONTENT']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Projektleiter_Vorname'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 6,
            'target_content' => ['firstname' => 'CONTENT', 'lastname' => '', 'email' => '', 'uri' => '']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Projektleiter_Nachname'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 6,
            'target_content' => ['firstname' => '', 'lastname' => 'CONTENT', 'email' => '', 'uri' => '']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Projektleiter_email'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 6,
            'target_content' => ['firstname' => '', 'lastname' => '', 'email' => 'CONTENT', 'uri' => '']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 4,
            'data_source_entity' => ['Weitere_PL_Vorname'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 7,
            'target_content' => ['firstname' => 'CONTENT', 'lastname' => '', 'email' => '', 'uri' => '']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 4,
            'data_source_entity' => ['Weitere_PL_Nachname'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 7,
            'target_content' => ['firstname' => '', 'lastname' => 'CONTENT', 'email' => '', 'uri' => '']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 4,
            'data_source_entity' => ['Weitere_PL_email'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 7,
            'target_content' => ['firstname' => '', 'lastname' => '', 'email' => 'CONTENT', 'uri' => '']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 2,
            'data_source_entity' => ['Institution'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 8,
            'target_content' => ['CONTENT']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Mittelgeber'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 9,
            'target_content' => ['CONTENT']
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Foerderprogramm'],
            'target_namespace' => 'project',
            'target_metadata_registry_id' => 10,
            'target_content' => ['CONTENT']
        ]);
    }
}