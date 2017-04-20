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
            'target_entity' => ['content' => '', 'language' => 'de'],
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Langtitel_en'],
            'target_namespace' => 'project',
            'target_entity' => ['content' => '', 'language' => 'en'],
        ]);

        DataSourceMapping::create([
            'data_source_id' => 1,
            'data_source_namespace_id' => 1,
            'data_source_entity' => ['Langtitel_en'],
            'target_namespace' => 'project',
            'target_entity' => ['title' => 'en'],
        ]);

    }
}